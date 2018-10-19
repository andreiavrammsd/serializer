<?php

namespace Serializer\Tests\ObjectToArray\Data;

class Forecast
{
    /**
     * @var Location
     *
     * @Serializer\Property("location")
     * @Serializer\Type("Serializer\Tests\ObjectToArray\Data")
     */
    private $location;

    /**
     * @var Current
     *
     * @Serializer\Property("current")
     * @Serializer\Type("Serializer\Tests\ObjectToArray\Data\Current")
     */
    private $current;

    /**
     * @var ForecastWeather
     *
     * @Serializer\Property("forecast")
     * @Serializer\Type("Apixu\Response\Forecast\ForecastWeather")
     */
    private $forecast;

    /**
     * @param Location $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @param Current $current
     */
    public function setCurrent($current)
    {
        $this->current = $current;
    }

    /**
     * @param ForecastWeather $forecast
     */
    public function setForecast($forecast)
    {
        $this->forecast = $forecast;
    }
}
