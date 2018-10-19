<?php

namespace Serializer\Tests\ObjectToArray\Data;

class CurrentCondition
{
    /**
     * @var string
     *
     * @Serializer\Property("text")
     * @Serializer\Type("string")
     */
    private $text;

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }
}
