<?php

namespace Serializer\Tests\ObjectToArray\Data;

class Current
{
    /**
     * @var int|null
     *
     * @Serializer\Property("last_updated_epoch")
     * @Serializer\Type("int")
     */
    private $lastUpdatedEpoch;

    /**
     * @var bool|null
     *
     * @Serializer\Property("is_day")
     * @Serializer\Type("bool")
     */
    private $day;

    /**
     * @var CurrentCondition
     *
     * @Serializer\Property("condition")
     * @Serializer\Type("Serializer\Tests\ObjectToArray\Data\CurrentCondition")
     */
    private $condition;

    /**
     * @var array
     */
    private $indices = [];

    /**
     * @param mixed $element
     */
    public function addIndices($element)
    {
        $this->indices[] = $element;
    }

    /**
     * @param array $indices
     */
    public function setIndices(array $indices)
    {
        $this->indices = $indices;
    }

    /**
     * @param int|null $lastUpdatedEpoch
     */
    public function setLastUpdatedEpoch($lastUpdatedEpoch)
    {
        $this->lastUpdatedEpoch = $lastUpdatedEpoch;
    }

    /**
     * @param bool|null $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @param \Serializer\Tests\ObjectToArray\Data\CurrentCondition $condition
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return bool|null
     */
    public function isDay() : bool
    {
        return $this->day;
    }
}
