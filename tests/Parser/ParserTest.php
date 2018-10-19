<?php declare(strict_types = 1);

namespace Serializer\Tests\Parser;

use PHPUnit\Framework\TestCase;
use Serializer\Collection;
use Serializer\Parser\Parser;
use Serializer\Parser\ParserInterface;
use Serializer\Tests\Parser\Data\Response\Condition;
use Serializer\Tests\Parser\Data\Response\ConditionItem;
use Serializer\Tests\Parser\Data\Response\ConditionItemNoArrayItem;
use Serializer\Tests\Parser\Data\Response\ConditionList;
use Serializer\Tests\Parser\Data\Response\ConditionListNoArrayItem;
use Serializer\Tests\Parser\Data\Response\Current;
use Serializer\Tests\Parser\Data\Response\CurrentWeather;
use Serializer\Tests\Parser\Data\Response\Location;
use Serializer\Tests\Parser\Data\Response\User;

class ParserTest extends TestCase
{
    /**
     * @var ParserInterface
     */
    private $parser;

    protected function setUp()
    {
        $this->parser = new Parser();

        $objectHandlers = [
            \Serializer\Handlers\Object\Collection::class,
        ];
        $propertyHandlers = [
            \Serializer\Handlers\Property\Property::class,
            \Serializer\Handlers\Property\Type::class,
            \Serializer\Handlers\Property\Callback::class,
        ];

        foreach ($objectHandlers as $class) {
            $this->parser->registerObjectHandler(new $class($this->parser));
        }
        foreach ($propertyHandlers as $class) {
            $this->parser->registerPropertyHandler(new $class($this->parser));
        }
    }

    public function testUnserializeProperty()
    {
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
        $object = $this->parser->parse(json_decode($input, true), $class);
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
        $this->assertNull($otherLocations[1]->getSecondaryName());
        $this->assertNull($otherLocations[1]->values);

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
           "points_a": "1",
           "points3": null,
           "friends":[
              {
                 "fname":"Doe",
                 "age":12
              },
              {
                 "fname":"john JOHNNY",
                 "age":2
              }
           ],
           "updated": 1538516060
        }';
        $class = User::class;

        /** @var User $object */
        $object = $this->parser->parse(json_decode($input, true), $class);
        $this->assertInstanceOf($class, $object);

        $this->assertSame('2', $object->firstName);
        $this->assertSame(12, $object->getAge());
        $this->assertEquals(new Collection([1, null, false, ' ', 'a', [1, 2, '3'],]), $object->points);
        $this->assertEquals(new Collection([1,]), $object->points2);
        $this->assertNull($object->points3);
        $this->assertContainsOnlyInstancesOf($class, $object->friends);
        $this->assertCount(2, $object->friends);
        $this->assertEquals((new \DateTime())->setTimestamp(1538516060), $object->updated);

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

    public function testUnserializeClass()
    {
        $input = '[
            {
                "code" : 1000,
                "day" : "Sunny",
                "night" : "Clear",
                "icon" : 113
            },
            {
                "code" : 1003,
                "day" : "Partly cloudy",
                "night" : "Partly cloudy",
                "icon" : 116
            }
        ]';

        /** @var ConditionList|ConditionItem[] $object */
        $object = $this->parser->parse(json_decode($input, true), ConditionList::class);
        $this->assertCount(2, $object);
        $this->assertContainsOnlyInstancesOf(ConditionItem::class, $object);

        $this->assertSame(1000, $object[0]->getCode());
        $this->assertSame('Sunny', $object[0]->getDay());
        $this->assertSame('Clear', $object[0]->getNight());
        $this->assertSame(113, $object[0]->getIcon());

        $this->assertSame(1003, $object[1]->getCode());
        $this->assertSame('Partly cloudy', $object[1]->getDay());
        $this->assertSame('Partly cloudy', $object[1]->getNight());
        $this->assertSame(116, $object[1]->getIcon());
    }

    public function testUnserializeClassWithNoArrayItem()
    {
        $input = '[
            {
            },
            {
            }
        ]';

        /** @var ConditionListNoArrayItem|ConditionItemNoArrayItem[] $object */
        $object = $this->parser->parse(json_decode($input, true), ConditionListNoArrayItem::class);
        $this->assertCount(2, $object);
        $this->assertContainsOnlyInstancesOf(ConditionItemNoArrayItem::class, $object);
    }
}
