<?php

namespace Serializer\Tests\Response;

class Location
{
    /**
     * @Serializer\Property("name")
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @Serializer\Property("region")
     * @Serializer\Type("string")
     */
    private $region;

    private $country;

    /**
     * @Serializer\Property("lat")
     * @Serializer\Type("float")
     */
    private $lat;

    /**
     * @Serializer\Type("string")
     */
    private $lon;
    
    /**
     * @Serializer\Property("tz_id")
     * @Serializer\Type("string")
     * @Serializer\Callback("trim")
     */
    public $timezone;

    /**
     * @Serializer\Property("localtime_epoch")
     * @Serializer\Type("int")
     */
    private $localtimeEpoch;
    
    /**
     * @Serializer\Property("localtime")
     * @Serializer\Type("DateTime", "Y-m-d H:i")
     */
    private $localtime;
    
    public function getName()
    {
        return $this->name;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getLat()
    {
        return $this->lat;
    }

    public function getLon()
    {
        return $this->lon;
    }

    public function getLocaltimeEpoch()
    {
        return $this->localtimeEpoch;
    }

    public function getLocaltime()
    {
        return $this->localtime;
    }
}
