<?php

namespace Serializer\Tests\Parser\Data\Response;

class ConditionItem
{
    private $code;
    private $day;
    private $night;
    private $icon;

    public function getCode()
    {
        return $this->code;
    }

    public function getDay()
    {
        return $this->day;
    }

    public function getNight()
    {
        return $this->night;
    }

    public function getIcon()
    {
        return $this->icon;
    }
}
