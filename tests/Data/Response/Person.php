<?php

namespace Serializer\Tests\Data\Response;

use Serializer\ToArray\ToArrayInterface;
use Serializer\ToArray\ToArrayTrait;

class Person implements ToArrayInterface
{
    use ToArrayTrait;

    public $name;

    /**
     * @Serializer\Type("array[Serializer\Tests\Data\Response\Person]")
     */
    public $related;

    /**
     * @Serializer\Property("points")
     * @Serializer\Type("collection")
     */
    public $points;

    /**
     * @Serializer\Property("age")
     * @Serializer\Type("int")
     */
    protected $age;

    public function getAge()
    {
        return $this->age;
    }
}
