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

    public function getDefinition($data)
    {
        $re = preg_match_all(self::ARGUMENTS_PATTERN, $data, $args);
        $args = $re !== false ? $args[1] : [];
        $name = array_shift($args);

        return ['name' => $name, 'args' => $args];
    }

    public function setVariableValue($definition, Variable $variable, Model $model)
    {
        $type = $definition['name'];
        $typeArgs = $definition['args'];

        $value = $variable->getValue();

        switch ($type) {
            case 'int':
                $value = (int)$value;
                break;

            case 'float':
                $value = (float)$value;
                break;

            case 'string':
                $value = (string)$value;
                break;

            case 'bool':
                $value = (bool)$value;
                break;

            case 'array':
                $value = (array)$value;
                break;

            case 'collection':
                if (is_array($value)) {
                    $out = [];
                    foreach ($value as $k => $d) { // do not cast to array, return null
                        $out [] = $this->serializer->parse($d, $model->getClass());
                    }

                    $value = new Collection($out); // needs recursion? check level n
                } else {
                    $value = null;
                }
                break;

            case 'DateTime':
                $format = $typeArgs[0];
                $value = \DateTime::createFromFormat($format, $value);
                break;

            default:
                preg_match(self::ITEM_SET_PATTERN, $type, $match);

                if ($match) {
                    if ($match[1] == 'array') {
                        $out = [];
                        foreach ((array)$value as $k => $d) { // do not cast to array, return null
                            $out [] = $this->serializer->parse($d, $model->getClass());
                        }

                        $value = $out;
                    }

                    if ($match[1] == 'collection') {
                        if (is_array($value)) {
                            $m = $match[2];

                            $out = [];
                            foreach ($value as $k => $d) { // do not cast to array, return null
                                $out [] = new $m($this->serializer->parse($d, $model->getClass()));
                            }

                            $value = new Collection($out);
                        } else {
                            $value = null;
                        }
                    }
                } else {
                    $value = $this->serializer->parse($value, $type, $typeArgs);
                }
                break;
        }

        $variable->setValue($value);
    }
}
