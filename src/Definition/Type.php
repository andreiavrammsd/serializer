<?php

namespace Serializer\Definition;

use Serializer\Collection;
use Serializer\Model;
use Serializer\Serializer;
use Serializer\Variable;

class Type implements DefinitionInterface
{
    const ITEM_SET_PATTERN = '#(array|collection)\[([a-z0-9_\\\]+)\]#i';

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * @param Serializer $serializer
     */
    public function __construct($serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition($data)
    {
        $matches = preg_match_all(self::ARGUMENTS_PATTERN, $data, $args);
        $args = $matches !== false ? $args[1] : [];
        $name = array_shift($args);

        return [
            'name' => $name,
            'args' => $args,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setVariableValue($definition, Variable $variable, Model $model)
    {
        $type = $definition['name'];
        $typeArgs = $definition['args'];

        $value = $variable->getValue();

        switch ($type) {
            case 'int':
                $result = (int)$value;
                break;

            case 'float':
                $result = (float)$value;
                break;

            case 'string':
                $result = (string)$value;
                break;

            case 'bool':
                $result = (bool)$value;
                break;

            case 'array':
                $result = (array)$value;
                break;

            case 'collection':
                $result = $this->getCollection($value, $model);
                break;

            case 'DateTime':
                $result = $this->getDateTime($value, $typeArgs);
                break;

            default:
                $result = $this->getDataSet($value, $model, $type);
                break;
        }

        $variable->setValue($result);
    }

    /**
     * @param array $value
     * @param Model $model
     * @return null|Collection
     */
    private function getCollection($value, Model $model)
    {
        if (!is_array($value)) {
            return null;
        }

        $out = [];
        foreach ($value as $v) {
            $out [] = $this->serializer->parse($v, $model->getClass());
        }

        return new Collection($out);
    }

    /**
     * @param mixed $value
     * @param array $typeArgs
     * @return \DateTime|null
     */
    private function getDateTime($value, array $typeArgs)
    {
        foreach ($typeArgs as $format) {
            $dateTime = \DateTime::createFromFormat($format, $value);
            if (false !== $dateTime) {
                return $dateTime;
            }
        }

        return null;
    }

    /**
     * @param mixed $value
     * @param Model $model
     * @param string $type
     * @return array|mixed|null|Collection
     */
    private function getDataSet($value, Model $model, $type)
    {
        preg_match(self::ITEM_SET_PATTERN, $type, $match);
        if ($match) {
            $result = null;

            if (is_array($value)) {
                if ($match[1] === 'array') {
                    $result = $this->getArray($value, $model);
                }

                if ($match[1] === 'collection') {
                    $objectClass = $match[2];
                    $result = $this->getCollectionOfClass($value, $model, $objectClass);
                }
            }

            return $result;
        }

        return $this->serializer->parse($value, $type);
    }

    /**
     * @param array $value
     * @param Model $model
     * @return array
     */
    private function getArray($value, $model)
    {
        $result = [];
        foreach ($value as $v) {
            $result [] = $this->serializer->parse($v, $model->getClass());
        }

        return $result;
    }

    /**
     * @param array $value
     * @param Model $model
     * @param string $class
     * @return Collection
     */
    private function getCollectionOfClass(array $value, Model $model, $class)
    {
        $out = [];
        foreach ($value as $d) {
            $out [] = new $class($this->serializer->parse($d, $model->getClass()));
        }

        return new Collection($out);
    }
}
