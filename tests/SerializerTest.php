<?php declare(strict_types = 1);

namespace Serializer\Tests;

use PHPUnit\Framework\TestCase;
use Serializer\Collection;
use Serializer\SerializerBuilder;
use Serializer\Tests\Data\Response\Condition;
use Serializer\Tests\Data\Response\Current;
use Serializer\Tests\Data\Response\CurrentWeather;
use Serializer\Tests\Data\Response\Location;
use Serializer\Tests\Data\Response\User;

class SerializerTest extends TestCase
{
    public function testUnserialize()
    {
        $serializer = SerializerBuilder::instance()
            ->setFormat('json')
            ->setDefinitions([])
            ->build();

        $input = '{
            "location": {
                "name": "London",
                "region": "",
                "country": "United Kingdom",
                "lat": 51.52,
                "lon": -0.11,
                "tz_id": " Europe/London ",
                "localtime_epoch": 1531989523,
                "localtime": "2018-07-19 9:38",
                "localtime2": "2018-07-19 9:38",
                "values": [1, "a"],
                "childLocation": {
                    "name": "London West",
                    "region": "West",
                    "values": [1, "a"]
                },
                "other_Locations": [
                    {
                        "name": "London Center",
                        "values": [2, "a", null, false, "", 0, -1],
                        "other_Locations": [
                            {
                                "name": "A"
                            },
                            {
                                "name": "B"
                            }
                        ]
                    },
                    {
                        "name": "London Center 2",
                        "values": null
                    }
                ]
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
        $this->assertNull($location->localtime2);
        $this->assertSame([1, 'a'], $location->values);

        /** @var Location $childLocation */
        $childLocation = $location->getChildLocation();
        $this->assertSame('London West', $childLocation->getName());
        $this->assertSame('West', $childLocation->getRegion());
        $this->assertSame([1, 'a'], $childLocation->values);

        /** @var Location[] $otherLocations */
        $otherLocations = $location->otherLocations;
        $this->assertContainsOnlyInstancesOf(Location::class, $otherLocations);
        $this->assertCount(2, $otherLocations);
        $this->assertSame('London Center', $otherLocations[0]->getName());
        $this->assertSame([2, 'a', null, false, '', 0, -1], $otherLocations[0]->values);
        $this->assertSame('A', $otherLocations[0]->otherLocations[0]->getName());
        $this->assertSame('B', $otherLocations[0]->otherLocations[1]->getName());
        $this->assertSame('London Center 2', $otherLocations[1]->getName());
        $this->assertSame([], $otherLocations[1]->values);

        /** @var Current $current */
        $current = $object->getCurrent();
        $this->assertSame(true, $current->isDay());

        /** @var Condition $condition */
        $condition = $current->getCondition();
        $this->assertSame('SUN', $condition->getText());

        $input = '{
           "fname":2,
           "age":12,
           "points": [1, null, false, " ", "a", [1, 2, "3"]],
           "friends":[
              {
                 "fname":"Doe",
                 "age":12
              },
              {
                 "fname":"john JOHNNY",
                 "age":2
              }
           ]
        }';
        $class = User::class;

        /** @var User $object */
        $object = $serializer->unserialize($input, $class);
        $this->assertInstanceOf($class, $object);

        $this->assertSame('2', $object->firstName);
        $this->assertSame(12, $object->getAge());
        $this->assertEquals(new Collection([1, null, false, ' ', 'a', [1, 2, '3'],]), $object->points);
        $this->assertContainsOnlyInstancesOf($class, $object->friends);
        $this->assertCount(2, $object->friends);

        /** @var User[] $friends */
        $friends = $object->friends;
        $this->assertSame('Doe', $friends[0]->firstName);
        $this->assertSame(12, $friends[0]->getAge());
        $this->assertSame('John Johnny', $friends[1]->firstName);
        $this->assertSame(2, $friends[1]->getAge());

        /** @var User[] $friends2 */
        $friends2 = $object->friends2;
        $this->assertSame('Doe', $friends2[0]->firstName);
        $this->assertSame(12, $friends2[0]->getAge());
        $this->assertSame('John Johnny', $friends2[1]->firstName);
        $this->assertSame(2, $friends2[1]->getAge());

        unset($friends2[1]);
        $this->assertFalse(array_key_exists(1, $friends2));

        $friends2[1] = $friends2[0];
        $this->assertSame($friends2[1], $friends2[0]);
        $this->assertFalse(empty($friends2[1]));
    }
}
