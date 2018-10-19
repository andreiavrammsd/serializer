<?php

namespace Serializer\Tests\Parser\Data\Response;

class CurrentWeather
{
    /**
     * @Serializer\Property("location")
     * @Serializer\Type("Serializer\Tests\Parser\Data\Response\Location")
     */
    private $location;

    /**
     * @Serializer\Property("current")
     * @Serializer\Type("Serializer\Tests\Parser\Data\Response\Current")
     */
    private $current;

    public function getLocation()
    {
        return $this->location;
    }

    public function getCurrent()
    {
        return $this->current;
    }
}
