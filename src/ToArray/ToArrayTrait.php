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
            $isToArray = $v instanceof ToArrayInterface;
            $value = $this->getValue($v, $isToArray);

            if ($value !== null) {
                $key = $this->getKey($k, $isToArray);
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
     * @param bool $isToArray
     * @return mixed
     */
    private function getValue($value, $isToArray)
    {
        return $isToArray ? $value->toArray() : $value;
    }

    /**
     * @param string $var
     * @param bool $isToArray
     * @return string
     */
    private function getKey(string $var, $isToArray)
    {
        if ($isToArray) {
            return $var;
        }

        $class = new \ReflectionClass($this);

        if (!$class->hasProperty($var)) {
            return $var;
        }

        $property = $class->getProperty($var);
        $doc = (string)$property->getDocComment();
        preg_match(ParserInterface::DEFINITION_PATTERN, $doc, $match);

        return $match ? trim($match[2], '" ') : $var;
    }
}
