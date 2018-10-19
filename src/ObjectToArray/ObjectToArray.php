<?php

namespace Serializer\ObjectToArray;

use Serializer\Collection;
use Serializer\Parser\ParserInterface;

final class ObjectToArray implements ObjectToArrayInterface
{
    /**
     * {@inheritdoc}
     */
    public function toArray(object $object) : array
    {
        if ($object instanceof Collection) {
            return $this->getValue($object);
        }

        $data = [];

        $class = new \ReflectionClass($object);
        $properties = $class->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $value = $this->getValue($property->getValue($object));

            $key = $this->getKey($property);

            $data[$key] = $value;
        }

        return $data;
    }


    /**
     * @param mixed $value
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

        if ($this->isObject($value)) {
            return $this->toArray($value);
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @return bool
     */
    private function isObject($value) : bool
    {
        if ($value instanceof \DateTime) {
            return false;
        }

        if ($value instanceof \stdClass) {
            return false;
        }

        return is_object($value);
    }

    /**
     * @param \ReflectionProperty $property
     * @return string
     */
    private function getKey(\ReflectionProperty $property)
    {
        $key = $property->getName();
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
