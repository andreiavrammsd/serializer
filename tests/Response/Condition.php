<?php

namespace Serializer\Tests\Response;

class Condition
{
    /**
     * @Serializer\Property("text")
     * @Serializer\Type("string")
     * @Serializer\Callback("strtoupper")
     * @Serializer\Callback("substr", "0", "3")
     */
    private $text;

    public function getText()
    {
        return $this->text;
    }
}
