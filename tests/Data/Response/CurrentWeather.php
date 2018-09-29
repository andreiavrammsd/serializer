<?php

namespace Serializer\Tests\Data\Response;

class CurrentWeather
{
    /**
     * @Serializer\Property("location")
     * @Serializer\Type("Serializer\Tests\Data\Response\Location")
     */
    private $location;

    /**
     * @Serializer\Property("current")
     * @Serializer\Type("Serializer\Tests\Data\Response\Current")
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
