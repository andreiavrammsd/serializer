<?php

namespace Serializer\Tests\Response;

class User
{
    /**
     * @Serializer\Property("firstname")
     * @Serializer\Type("string")
     */
    public $firstName;

    /**
     * @_Serializer\Property("age")
     * @Serializer\Type("int")
     */
    private $age;

    /**
     * @Serializer\Property("friends")
     * @Serializer\Type("array[Serializer\Tests\Response\User]")
     */
    public $friends;


    /**
     * @Serializer\Property("friends")
     * @Serializer\Type("collection")
     */
    public $friends2;


    /**
     * @Serializer\Property("friends")
     * @Serializer\Type("collection[Serializer\Tests\Response\User]")
     */
    public $friends3;


    function getAge()
    {
        return $this->age;
    }
}
