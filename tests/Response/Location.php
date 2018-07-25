<?php

namespace Serializer\Tests\Response;

class Location
{
    /**
     * @Serializer\Property("name")
     * @Serializer\Type("string")
     */
    private $name;

    private $country;

    public function getName()
    {
        return $this->name;
    }

    public function getCountry()
    {
        return $this->country;
    }
}
