<?php

namespace Serializer\Tests\Data\Response;

use Serializer\ToArray\ToArrayInterface;
use Serializer\ToArray\ToArrayTrait;

class User implements ToArrayInterface
{
    use ToArrayTrait;

    /**
     * @Serializer\Property("fname")
     * @Serializer\Type("string")
     * @Serializer\Callback("[Serializer\Tests\Data\Callback\TextTransform, toName]", "3")
     */
    public $firstName;

    /**
     * @Serializer\Property("friends")
     * @Serializer\Type("array[Serializer\Tests\Data\Response\User]")
     */
    public $friends;

    /**
     * @Serializer\Property("friends")
     * @Serializer\Type("collection[Serializer\Tests\Data\Response\User]")
     */
    public $friends2;

    /**
     * @Serializer\Property("points")
     * @Serializer\Type("collection")
     */
    public $points;

    /**
     * @Serializer\Property("points2")
     * @Serializer\Type("collection")
     */
    public $points2;

    /**
     * @Serializer\Property("points3")
     * @Serializer\Type("collection")
     */
    public $points3;

    /**
     * @Serializer\Property("age")
     * @Serializer\Type("int")
     */
    private $age;

    /**
     * @Serializer\Property("updated")
     * @Serializer\Type("DateTime")
     */
    public $updated;

    public function getAge()
    {
        return $this->age;
    }
}
