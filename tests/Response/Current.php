<?php

namespace Serializer\Tests\Response;

class Current
{
    /**
     * @Serializer\Property("last_updated")
     * @Serializer\Type("Serializer\CustomType\Time","Y-m-d H:i", "Y-m-d", " ")
     */
    private $lastUpdated;

    /**
     * @Serializer\Property("last_updated")
     * @Serializer\Type("DateTime","Y-m-d H:i", "Y-m-d", " ")
     */
    private $lastUpdated2;

    /**
     * @Serializer\Property("condition")
     * @Serializer\Type("Serializer\Tests\Response\Condition")
     */
    private $condition;

    /**
     * @Serializer\Property("is_day")
     * @Serializer\Type("bool")
     */
    private $day;

    function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    function getCondition()
    {
        return $this->condition;
    }

    function isDay()
    {
        return $this->day;
    }
}
