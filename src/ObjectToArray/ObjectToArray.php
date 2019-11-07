<?php

namespace Serializer\ObjectToArray;

use DateTime;
use ReflectionException;
use Serializer\Collection;
use Serializer\DefinitionPatterns;
use ReflectionClass;

class ObjectToArray implements ObjectToArrayInterface
{
    /**
     * {@inheritdoc}
     * @throws ReflectionException
     */
    public function toArray($object): array
    {
        if ($object instanceof Collection) {
            return $this->getValue($object);
        }

        $data = [];

        $class = new ReflectionClass($object);
        $properties = $class->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);

            $doc = $property->getDocComment();
            $value = $this->getValue($property->getValue($object));
            $value = $this->formatValue($value, (string)$doc);
            if ($value === null && $doc !== false && $this->ignoreNull($doc)) {
                continue;
            }

            $key = $this->getKey($property->getName(), (string)$doc);
            $data[$key] = $value;
        }

        return $data;
    }

    /**
     * @param mixed $value
     * @param string|null $doc
     * @return mixed
     * @SuppressWarnings("unused")
     */
    protected function formatValue($value, string $doc = null)
    {
        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed
     * @throws ReflectionException
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
    private function isObject($value): bool
    {
        if ($value instanceof DateTime) {
            return false;
        }

        if ($value instanceof \stdClass) {
            return false;
        }

        return is_object($value);
    }

    /**
     * @param string $key
     * @param string $doc
     * @return string
     */
    private function getKey(string $key, string $doc): string
    {
        preg_match(DefinitionPatterns::PROPERTY, $doc, $match);
        if ($match) {
            $key = $match[1];
        }

        return $key;
    }

    /**
     * @param string $doc
     * @return bool
     */
    private function ignoreNull(string $doc): bool
    {
        return strpos($doc, DefinitionPatterns::IGNORE_NULL) !== false;
    }
}
