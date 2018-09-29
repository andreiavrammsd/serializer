<?php

namespace Serializer\Tests\Data\Response;

class User
{
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
     * @Serializer\Type("collection")
     */
    public $friends2;

    /**
     * @Serializer\Property("friends")
     * @Serializer\Type("collection[Serializer\Tests\Data\Response\User]")
     */
    public $friends3;

    /**
     * @Serializer\Property("age")
     * @Serializer\Type("int")
     */
    private $age;

    public function getAge()
    {
        return $this->age;
    }
}
