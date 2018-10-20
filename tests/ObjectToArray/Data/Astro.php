<?php

namespace Serializer\Tests\ObjectToArray\Data;

class Astro
{
    /**
     * @var string|null
     *
     * @Serializer\Property("sunrise")
     * @Serializer\Type("string")
     * @Serializer\IgnoreNull()
     */
    private $sunrise;

    /**
     * @param string $sunrise
     */
    public function setSunrise(?string $sunrise)
    {
        $this->sunrise = $sunrise;
    }
}
