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
        $result = null;

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
                if (is_array($value)) {
                    $result = $this->getCollection($value, $model);
                }
                break;

            case 'DateTime':
                $result = $this->getDateTime($value, $typeArgs);
                break;

            default:
                preg_match(self::ITEM_SET_PATTERN, $type, $match);

                if ($match) {
                    if ($match[1] == 'array' && is_array($value)) {
                        $result = $this->getArray($value, $model);
                    }

                    if ($match[1] == 'collection' && is_array($value)) {
                        $objectClass = $match[2];
                        $result = $this->getCollectionOfType($value, $model, $objectClass);
                    }
                } else {
                    $result = $this->serializer->parse($value, $type);
                }
                break;
        }

        $variable->setValue($result);
    }

    /**
     * @param array $value
     * @param Model $model
     * @return Collection
     */
    private function getCollection(array $value, Model $model)
    {
        $out = [];
        foreach ($value as $v) {
            $out [] = $this->serializer->parse($v, $model->getClass());
        }

        return new Collection($out); // needs recursion? check level n
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
     * @param string $objectClass
     * @return Collection
     */
    private function getCollectionOfType(array $value, Model $model, $objectClass)
    {
        $out = [];
        foreach ($value as $d) {
            $out [] = new $objectClass($this->serializer->parse($d, $model->getClass()));
        }

        return new Collection($out);
    }
}
