<?php

namespace Serializer\ToArray;

use Serializer\Parser\ParserInterface;

trait ToArrayTrait
{
    /**
     * {@inheritdoc}
     */
    public function toArray() : ?array
    {
        $data = [];
        foreach ($this as $k => $v) {
            $value = $this->getValue($v);

            if ($value !== null) {
                $key = $this->getKey($k);
                $data[$key] = $value;
            }
        }

        if (count($data) === 0) {
            return null;
        }

        return $data;
    }


    /**
     * @param mixed|ToArrayInterface $value
     * @return mixed
     */
    private function getValue($value)
    {
        if (is_iterable($value)) {
            $result = [];
            foreach ($value as $k => $v) {
                $result[$k] = $this->getValue($v);
            }

            return $result;
        }

        return $value instanceof ToArrayInterface ? $value->toArray() : $value;
    }

    /**
     * @param string $var
     * @return string
     */
    private function getKey(string $var)
    {
        $class = new \ReflectionClass($this);

        if (!$class->hasProperty($var)) {
            return $var;
        }

        $key = $var;

        $property = $class->getProperty($var);
        $doc = (string)$property->getDocComment();

        if ($doc) {
            preg_match(ParserInterface::PROPERTY_DEFINITION_PATTERN, $doc, $match);
            if ($match) {
                $key = $match[1];
            }
        }

        return $key;
    }
}
