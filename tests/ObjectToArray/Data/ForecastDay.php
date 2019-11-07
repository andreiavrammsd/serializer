<?php

namespace Serializer\Tests\ObjectToArray\Data;

use DateTime;

class ForecastDay
{
    /**
     * @var DateTime
     *
     * @Serializer\Property("date")
     * @Serializer\Type("DateTime", "Y-m-d")
     */
    private $date;

   /**
     * @var DateTime
     *
     * @Serializer\Property("wrong_date")
     */
    private $wrongDate;

    /**
     * @var DateTime
     *
     * @Serializer\Property("wrong_date_args")
     * @Serializer\Type("DateTime)
     */
    private $wrongDateArgs;

    /**
     * @var DateTime
     *
     * @Serializer\Property("wrong_date_type")
     * @Serializer\Type("DateTim)
     * @Serializer\IgnoreNull()
     */
    private $wrongDateType;

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
     * @param DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @param DateTime $wrongDate
     */
    public function setWrongDate($wrongDate)
    {
        $this->wrongDate = $wrongDate;
    }

    /**
     * @param DateTime $wrongDateArgs
     */
    public function setWrongDateArgs($wrongDateArgs)
    {
        $this->wrongDateArgs = $wrongDateArgs;
    }

    /**
     * @param DateTime $wrongDateType
     */
    public function setWrongDateType($wrongDateType)
    {
        $this->wrongDateType = $wrongDateType;
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
