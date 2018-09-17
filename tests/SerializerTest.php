<?php

namespace Serializer\Tests;

use PHPUnit\Framework\TestCase;
use Serializer\Config;
use Serializer\SerializerBuilder;
use Serializer\Tests\Response\Condition;
use Serializer\Tests\Response\Current;
use Serializer\Tests\Response\CurrentWeather;
use Serializer\Tests\Response\Location;
use Serializer\Tests\Response\User;

class Serializer extends TestCase
{
    public function testUnserialize()
    {
        $config = new Config();
        $config->setFormat('json');
        $serializer = SerializerBuilder::build($config);

        $input = '{
            "location": {
                "name": "London",
                "region": "",
                "country": "United Kingdom",
                "lat": 51.52,
                "lon": -0.11,
                "tz_id": " Europe/London ",
                "localtime_epoch": 1531989523,
                "localtime": "2018-07-19 9:38"
            },
            "current": {
                "last_updated_epoch": 1531989006,
                "last_updated": "2018-07-19 09:30",
                "temp_c": 21.0,
                "temp_f": 69.8,
                "is_day": 1,
                "condition": {
                    "text": "Sunny",
                    "icon": "//cdn.apixu.com/weather/64x64/day/113.png",
                    "code": 1000
                },
                "wind_mph": 3.8,
                "wind_kph": 6.1,
                "wind_degree": 60,
                "wind_dir": "ENE",
                "pressure_mb": 1019.0,
                "pressure_in": 30.6,
                "precip_mm": 0.0,
                "precip_in": 0.0,
                "humidity": 53,
                "cloud": 0,
                "feelslike_c": 21.0,
                "feelslike_f": 69.8,
                "vis_km": 10.0,
                "vis_miles": 6.0
            }
        }';
        $class = CurrentWeather::class;

        /** @var CurrentWeather $object */
        $object = $serializer->unserialize($input, $class);
        $this->assertInstanceOf($class, $object);

        /** @var Location $location */
        $location = $object->getLocation();
        $this->assertSame('London', $location->getName());
        $this->assertSame('', $location->getRegion());
        $this->assertSame(51.52, $location->getLat());
        $this->assertSame('-0.11', $location->getLon());
        $this->assertSame('Europe/London', $location->timezone);
        $this->assertSame(1531989523, $location->getLocaltimeEpoch());
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d h:i', '2018-07-19 9:38'), $location->getLocaltime());

        /** @var Current $current */
        $current = $object->getCurrent();
        $this->assertInternalType('bool', $current->isDay());
        $this->assertSame(true, $current->isDay());

        /** @var Condition $condition */
        $condition = $current->getCondition();
        $this->assertSame('SUN', $condition->getText());

        $input = '{
           "firstname":2,
           "age":12,
           "friends":[
              {
                 "firstname":"Doe",
                 "age":12
              },
              {
                 "firstname":"John",
                 "age":2
              }
           ]
        }';
        $class = User::class;

        /** @var User $object */
        $object = $serializer->unserialize($input, $class);
        $this->assertInstanceOf($class, $object);

        $this->assertSame(12, $object->getAge());
        $this->assertContainsOnlyInstancesOf($class, $object->friends);
        $this->assertCount(2, $object->friends);
    }
}
