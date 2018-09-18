<?php

namespace Serializer;

use Serializer\CustomType\CustomTypeHandler;
use Serializer\Definition\DefinitionInterface;
use Serializer\Format\FormatInterface;

class Serializer
{
    const DEFINITION_PATTERN = '#@Serializer\\\([a-z]+)\((.+)\)#i';

    /**
     * @var FormatInterface
     */
    private $format;

    /**
     * @var CustomTypeHandler
     */
    private $customType;

    /**
     * @var array[DefinitionInterface]
     */
    private $definitionHandlers;

    /**
     * @param FormatInterface $format
     * @param CustomTypeHandler $customType
     */
    public function __construct(FormatInterface $format, CustomTypeHandler $customType)
    {
        $this->format = $format;
        $this->customType = $customType;
    }

    /**
     * @param string $class
     */
    public function registerDefinitionHandler($class)
    {
        $this->definitionHandlers [] = new $class($this);
    }

    /**
     * @param string $input
     * @param string $class
     * @return object
     */
    public function unserialize($input, $class)
    {
        $data = $this->format->decode($input);

        return $this->parse($data, $class);
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param array $args
     * @return object
     */
    public function parse($data, $class, $args = [])
    {
        if ($this->customType->isCustomType($class)) {
            return $this->customType->getValue($class, $args, $data);
        }

        $model = new Model($data, $class);
        $reflectionClass = new \ReflectionClass($class);
        $object = $reflectionClass->newInstanceWithoutConstructor();

        foreach ($reflectionClass->getProperties() as $property) {
            $definitions = $this->getDefinitions((string)$property->getDocComment());

            $variable = new Variable($property, $object);
            $variable->setValue($this->getDefaultValue($property, $model->getData()));

            /** @var DefinitionInterface $handler */
            foreach ($this->definitionHandlers as $handler) {
                $name = $this->getHandlerName($handler);

                if (!isset($definitions[$name])) {
                    continue;
                }

                foreach ($definitions[$name] as $d) {
                    $definition = $handler->getDefinition($d);
                    $handler->setVariableValue($definition, $variable, $model);
                }
            }
        }

        return $object;
    }

    /**
     * @param DefinitionInterface $handler
     * @return string
     */
    private function getHandlerName($handler)
    {
        $className = get_class($handler);

        return substr($className, strrpos($className, '\\') + 1);
    }

    /**
     * @param string $comment
     * @return array
     */
    private function getDefinitions($comment)
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
    private function getDefaultValue($property, array $data)
    {
        $name = $property->getName();

        return array_key_exists($name, $data) ? $data[$name] : null;
    }
}
