<?php

namespace Serializer\Tests\Data\Response;

use Serializer\ToArray\ToArrayInterface;
use Serializer\ToArray\ToArrayTrait;

class ConditionItem implements ToArrayInterface
{
    use ToArrayTrait;

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
