<?php

namespace Serializer\Tests\ObjectToArray\Data;

class Day
{
    /**
     * @var \stdClass
     *
     * @Serializer\Property("avghumidity")
     */
    private $avgHumidity;

    /**
     * @var CurrentCondition
     *
     * @Serializer\Property("condition")
     * @Serializer\Type("Serializer\Tests\ObjectToArray\Data\CurrentCondition")
     */
    private $condition;

    private $state;

    /**
     * @param \stdClass $avgHumidity
     */
    public function setAvgHumidity(\stdClass $avgHumidity)
    {
        $this->avgHumidity = $avgHumidity;
    }

    /**
     * @param CurrentCondition $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @param int $state
     */
    public function setState(int $state)
    {
        $this->state = $state;
    }
}
