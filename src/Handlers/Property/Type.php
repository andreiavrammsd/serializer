<?php declare(strict_types = 1);

namespace Serializer\Handlers\Property;

use Serializer\Collection;
use Serializer\Parser\ParserInterface;
use Serializer\Parser\Variable;

class Type implements PropertyHandlerInterface
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
    public function setVariableValue($definition, Variable $variable, array $data)
    {
        $value = $variable->getValue();
        if ($value === null) {
            return null;
        }

        $type = $definition['name'];
        $typeArgs = $definition['args'];

        switch ($type) {
            case 'int':
            case 'float':
            case 'string':
            case 'bool':
            case 'array':
                settype($value, $type);
                $result = $value;
                break;

            case 'collection':
                $result = $this->getCollection($value);
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
     * @return null|Collection
     */
    private function getCollection($value)
    {
        $data = $value;
        if (!is_array($value)) {
            $data = [$value];
        }

        return new Collection($data);
    }

    /**
     * @param mixed $timestamp
     * @param array $formats
     * @return \DateTime|null
     */
    private function getDateTime($timestamp, array $formats)
    {
        if (is_int($timestamp)) {
            $dateTime = new \DateTime();
            $dateTime->setTimestamp($timestamp);
            return $dateTime;
        }

        if (is_string($timestamp)) {
            foreach ($formats as $format) {
                $dateTime = \DateTime::createFromFormat($format, $timestamp);
                if (false !== $dateTime) {
                    return $dateTime;
                }
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
