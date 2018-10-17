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

        $property = $class->getProperty($var);
        $doc = (string)$property->getDocComment();
        preg_match(ParserInterface::DEFINITION_PATTERN, $doc, $match);

        return $match ? trim($match[2], '" ') : $var;
    }
}
