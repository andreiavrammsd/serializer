<?php declare(strict_types = 1);

namespace Serializer\Parser;

use Serializer\Definition\DefinitionInterface;

class Parser implements ParserInterface
{
    const DEFINITION_PATTERN = '#@Serializer\\\([a-z]+)\((.+)\)#i';

    /**
     * @var array[DefinitionInterface]
     */
    private $definitionHandlers;

    /**
     * {@inheritdoc}
     */
    public function registerDefinitionHandler(DefinitionInterface $handler)
    {
        $this->definitionHandlers [$this->getHandlerName($handler)] = $handler;
    }

    /**
     * @param DefinitionInterface $handler
     * @return string
     */
    private function getHandlerName(DefinitionInterface $handler)
    {
        $className = get_class($handler);

        return substr($className, strrpos($className, '\\') + 1);
    }

    /**
     * {@inheritdoc}
     */
    public function parse(array $data, string $class)
    {
        $reflectionClass = new \ReflectionClass($class);
        $object = $reflectionClass->newInstanceWithoutConstructor();

        foreach ($reflectionClass->getProperties() as $property) {
            $definitions = $this->getDefinitions((string)$property->getDocComment());

            $variable = new Variable($property, $object);
            $variable->setValue($this->getDefaultValue($property, $data));

            /** @var DefinitionInterface $handler */
            foreach ($this->definitionHandlers as $name => $handler) {
                if (!array_key_exists($name, $definitions)) {
                    continue;
                }

                foreach ($definitions[$name] as $d) {
                    $definition = $handler->getDefinition($d);
                    $handler->setVariableValue($definition, $variable, $data);
                }
            }
        }

        return $object;
    }

    /**
     * @param string $comment
     * @return array
     */
    private function getDefinitions(string $comment) : array
    {
        $definitions = [];
        preg_match_all(self::DEFINITION_PATTERN, $comment, $matches);

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
