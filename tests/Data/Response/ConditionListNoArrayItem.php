<?php

namespace Serializer\Tests\Data\Response;

use Serializer\Collection;
use Serializer\ToArray\ToArrayInterface;
use Serializer\ToArray\ToArrayTrait;

/**
 * @Serializer\Collection("Serializer\Tests\Data\Response\ConditionItemNoArrayItem")
 */
class ConditionListNoArrayItem extends Collection implements ToArrayInterface
{
    use ToArrayTrait;
}
