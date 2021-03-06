<?php

namespace Serializer\Tests\ObjectToArray\Data;

use Serializer\Collection;

class ForecastWeather
{
    /**
     * @var Collection[Apixu\Response\Forecast\ForecastDay]
     *
     * @Serializer\Property("forecastday")
     * @Serializer\Type("collection[Serializer\Tests\ObjectToArray\Data\ForecastDay]")
     */
    private $forecastDay;

    /**
     * @param Collection $forecastDay
     */
    public function setForecastDay($forecastDay)
    {
        $this->forecastDay = $forecastDay;
    }
}
