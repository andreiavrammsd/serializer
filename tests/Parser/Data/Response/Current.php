<?php

namespace Serializer\Tests\Parser\Data\Response;

class Current
{
    /**
     * @Serializer\Property("last_updated")
     * @Serializer\Type("DateTime","Y-m-d H:i", "Y-m-d", " ")
     */
    private $lastUpdated;

    /**
     * @Serializer\Property("condition")
     * @Serializer\Type("Serializer\Tests\Parser\Data\Response\Condition")
     */
    private $condition;

    /**
     * @Serializer\Property("is_day")
     * @Serializer\Type("bool")
     */
    private $day;

    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function isDay()
    {
        return $this->day;
    }
}
