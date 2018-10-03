<?php

namespace Serializer\Tests\Data\Response;

use Serializer\ToArray\ToArrayInterface;
use Serializer\ToArray\ToArrayTrait;

class NullableArray implements ToArrayInterface
{
    use ToArrayTrait;

    public $var1;
}
