<?php

namespace Serializer\Tests\Response;

class CurrentWeather
{
    /**
     * @Serializer\Property("location")
     * @Serializer\Type("Serializer\Tests\Response\Location")
     */
    private $location;

    /**
     * @Serializer\Property("current")
     * @Serializer\Type("Serializer\Tests\Response\Current")
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
