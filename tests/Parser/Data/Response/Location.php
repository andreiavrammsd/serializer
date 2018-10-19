<?php

namespace Serializer\Tests\Parser\Data\Response;

class Location
{
    /**
     * @Serializer\Property("tz_id")
     * @Serializer\Type("string")
     * @Serializer\Callback("trim")
     */
    public $timezone;

    /**
     * @Serializer\Property("localtime2")
     * @Serializer\Type("DateTime", "Y-m-d H")
     */
    public $localtime2;

    /**
     * @Serializer\Property("values")
     * @Serializer\Type("array")
     */
    public $values;

    /**
     * @Serializer\Property("other_Locations")
     * @Serializer\Type("array[Serializer\Tests\Parser\Data\Response\Location]")
     */
    public $otherLocations;

    /**
     * @Serializer\Property("name")
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @Serializer\Property("secondary_name")
     * @Serializer\Type("string")
     */
    private $secondaryName;

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
     * @Serializer\Property("localtime_epoch")
     * @Serializer\Type("int")
     */
    private $localtimeEpoch;

    /**
     * @Serializer\Property("localtime")
     * @Serializer\Type("DateTime", "Y-m-d H:i")
     */
    private $localtime;

    /**
     * @Serializer\Property("childLocation")
     * @Serializer\Type("Serializer\Tests\Parser\Data\Response\Location")
     */
    private $childLocation;

    public function getName()
    {
        return $this->name;
    }

    public function getSecondaryName() : ?string
    {
        return $this->secondaryName;
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

    public function getChildLocation()
    {
        return $this->childLocation;
    }
}
