<?php declare(strict_types = 1);

namespace Serializer\Parser;

use Serializer\Handlers\HandlerInterface;
use Serializer\Handlers\Object\ObjectHandlerInterface;
use Serializer\Handlers\Property\PropertyHandlerInterface;
use Serializer\DefinitionPatterns;

class Parser implements ParserInterface
{
    /**
     * @var array[ObjectHandlerInterface]
     */
    private $objectHandlers;

    /**
     * @var array[PropertyHandlerInterface]
     */
    private $propertyHandlers;

    /**
     * {@inheritdoc}
     */
    public function registerObjectHandler(ObjectHandlerInterface $handler)
    {
        $this->objectHandlers [$this->getHandlerName($handler)] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function registerPropertyHandler(PropertyHandlerInterface $handler)
    {
        $this->propertyHandlers [$this->getHandlerName($handler)] = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function parse(array $data, string $class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $object = $reflectionClass->newInstanceWithoutConstructor();

        $this->parseClass($reflectionClass, $object, $data);
        $this->parseProperties($reflectionClass, $object, $data);

        return $object;
    }

    /**
     * @param HandlerInterface $handler
     * @return string
     */
    private function getHandlerName(HandlerInterface $handler)
    {
        $className = get_class($handler);

        return substr($className, strrpos($className, '\\') + 1);
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @param object $object
     * @param array $data
     */
    private function parseClass(\ReflectionClass $reflectionClass, $object, array $data)
    {
        $definitions = $this->getDefinitions((string)$reflectionClass->getDocComment());

        /** @var ObjectHandlerInterface $handler */
        foreach ($this->objectHandlers as $name => $handler) {
            if (!array_key_exists($name, $definitions)) {
                continue;
            }

            foreach ($definitions[$name] as $d) {
                $definition = $handler->getDefinition($d);
                $handler->setObject($definition, $object, $data);
            }
        }
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @param object $object
     * @param array $data
     */
    private function parseProperties(\ReflectionClass $reflectionClass, $object, array $data)
    {
        foreach ($reflectionClass->getProperties() as $property) {
            $definitions = $this->getDefinitions((string)$property->getDocComment());

            $variable = new Variable($property, $object);
            $variable->setValue($this->getDefaultValue($property, $data));

            /** @var PropertyHandlerInterface $handler */
            foreach ($this->propertyHandlers as $name => $handler) {
                if (!array_key_exists($name, $definitions)) {
                    continue;
                }

                foreach ($definitions[$name] as $d) {
                    $definition = $handler->getDefinition($d);
                    $handler->setVariableValue($definition, $variable, $data);
                }
            }
        }
    }

    /**
     * @param string $comment
     * @return array
     */
    private function getDefinitions(string $comment) : array
    {
        $definitions = [];
        preg_match_all(DefinitionPatterns::DEFINITION, $comment, $matches);

        foreach ($matches[1] as $key => $value) {
            $definitions[$value][] = $matches[2][$key];
        }

        return $definitions;
    }

    /**
     * @param \ReflectionProperty $property
     * @param array $data
     * @return mixed
     */
    private function getDefaultValue(\ReflectionProperty $property, array $data)
    {
        $name = $property->getName();

        if (array_key_exists($name, $data)) {
            return $data[$name];
        }

        return null;
    }
}
