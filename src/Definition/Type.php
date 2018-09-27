<?php

namespace Serializer\Definition;

use Serializer\Collection;
use Serializer\Parser\Model;
use Serializer\Parser\ParserInterface;
use Serializer\Parser\Variable;

class Type implements DefinitionInterface
{
    const ITEM_SET_PATTERN = '#(array|collection)\[([a-z0-9_\\\]+)\]#i';

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
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
                $result = $this->getDataSet($value, $type);
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
            $out [] = $this->parser->parse($v, $model->getClass());
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
     * @param string $type
     * @return array|mixed|null|Collection
     */
    private function getDataSet($value, $type)
    {
        if ($value === null) {
            return null;
        }

        preg_match(self::ITEM_SET_PATTERN, $type, $match);
        if ($match) {
            $result = null;

            if (is_array($value)) {
                $type = $match[1];
                $class = $match[2];

                switch ($type) {
                    case 'array':
                        $result = $this->getArray($value, $class);
                        break;
                    case 'collection':
                        $result = new Collection($this->getArray($value, $class));
                        break;
                }
            }

            return $result;
        }

        return $this->parser->parse($value, $type);
    }

    /**
     * @param array $value
     * @param string $class
     * @return array
     */
    private function getArray($value, $class)
    {
        $result = [];
        foreach ($value as $v) {
            $result [] = $this->parser->parse($v, $class);
        }

        return $result;
    }
}
