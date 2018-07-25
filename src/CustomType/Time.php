<?php

namespace Serializer\CustomType;

class Time implements CustomTypeInterface
{
    /**
     * @var array
     */
    private $formats;

    /**
     * @param array<int, mixed> $args
     */
    public function __construct(...$args)
    {
        $this->formats = $args;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue($input)
    {
        foreach ($this->formats as $format) {
            $res = \DateTime::createFromFormat($format, $input);
            if (false !== $res) {
                return $res;
            }
        }

        return null;
    }
}
