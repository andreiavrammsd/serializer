<?php

namespace Serializer\Tests\ObjectToArray\Data;

class ForecastDay
{
    /**
     * @var \DateTime
     *
     * @Serializer\Property("date")
     * @Serializer\Type("DateTime", "Y-m-d")
     */
    private $date;

    /**
     * @var Day
     *
     * @Serializer\Property("day")
     * @Serializer\Type("Serializer\Tests\ObjectToArray\Data\Day")
     */
    private $day;

    /**
     * @var Astro
     *
     * @Serializer\Property("astro")
     * @Serializer\Type("Serializer\Tests\ObjectToArray\Data\Astro")
     */
    private $astro;

    /**
     * @var array[Serializer\Tests\ObjectToArray\Data\Astro]
     *
     * @Serializer\Property("astros")
     * @Serializer\Type("array[Serializer\Tests\ObjectToArray\Data\Astro]")
     */
    private $astros;

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param Day $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @param Astro $astro
     */
    public function setAstro($astro)
    {
        $this->astro = $astro;
    }

    /**
     * @param array [Serializer\Tests\ObjectToArray\Data\Astro] $astros
     */
    public function setAstros(array $astros)
    {
        $this->astros = $astros;
    }
}
