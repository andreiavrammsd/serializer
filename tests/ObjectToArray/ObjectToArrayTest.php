<?php declare(strict_types = 1);

namespace Serializer\Tests\ObjectToArray;

use Exception;
use DateTime;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use Serializer\Collection;
use Serializer\ObjectToArray\ObjectToArray;
use Serializer\ObjectToArray\ObjectToArrayInterface;
use Serializer\Tests\ObjectToArray\Data\Astro;
use Serializer\Tests\ObjectToArray\Data\Current;
use Serializer\Tests\ObjectToArray\Data\CurrentCondition;
use Serializer\Tests\ObjectToArray\Data\Day;
use Serializer\Tests\ObjectToArray\Data\Forecast;
use Serializer\Tests\ObjectToArray\Data\ForecastDay;
use Serializer\Tests\ObjectToArray\Data\ForecastWeather;
use Serializer\Tests\ObjectToArray\Data\Location;

class ObjectToArrayTest extends TestCase
{
    /**
     * @var ObjectToArrayInterface
     */
    private $toArray;

    protected function setUp()
    {
        $this->toArray = new ObjectToArray();
    }

    /**
     * @dataProvider data
     * @param object $object
     * @param array $expected
     * @throws ReflectionException
     */
    public function testToArray($object, array $expected)
    {
        $array = $this->toArray->toArray($object);
        $this->assertEquals($expected, $array);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function data() : array
    {
        $forecast = new Forecast();

        $location = new Location();
        $location->setName('Paris');
        $location->setLat(34);
        $location->setTimezone('Europe/Paris');
        $forecast->setLocation($location);

        $condition = new CurrentCondition();
        $condition->setText('Txt');

        $current = new Current();
        $current->setLastUpdatedEpoch(1539964050);
        $current->setDay(false);
        $current->addIndices(1);
        $current->addIndices(null);
        $current->addIndices('a');
        $current->setCondition($condition);
        $forecast->setCurrent($current);

        $day = new Day();
        $day->setAvgHumidity((object)34.4);
        $day->setCondition(new CurrentCondition());
        $day->setState(2);
        $astro = new Astro();
        $astro->setSunrise(null);

        $forecastDayItem = new ForecastDay();
        $forecastDayItem->setDate(new \DateTime('2018-10-19'));
        $forecastDayItem->setWrongDate(new \DateTime('2018-10-19'));
        $forecastDayItem->setWrongDateArgs(new \DateTime('2018-10-19'));
        $forecastDayItem->setDay($day);
        $forecastDayItem->setAstro($astro);
        $astro2 = clone $astro;
        $astro2->setSunrise('1AM');
        $astro3 = clone $astro;
        $astro3->setSunrise('2AM');
        $forecastDayItem->setAstros([$astro2, $astro3]);

        $forecastDayItem2 = clone $forecastDayItem;
        $forecastDayItem2->setDate(new \DateTime('2018-10-20'));

        $forecastDayData = [
            $forecastDayItem,
            $forecastDayItem2,
        ];
        $forecastDay = new Collection($forecastDayData);
        $forecastWeather = new ForecastWeather();
        $forecastWeather->setForecastDay($forecastDay);
        $forecast->setForecast($forecastWeather);

        $expected = [
            'location' => [
                'id' => null,
                'name' => 'Paris',
                'lat' => 34,
                'tz_id' => 'Europe/Paris',
            ],
            'current' => [
                'last_updated_epoch' => 1539964050,
                'is_day' => false,
                'condition' => [
                    'text' => 'Txt',
                ],
                'indices' => [
                    0 => 1,
                    1 => null,
                    2 => 'a',
                ],
            ],
            'forecast' => [
                'forecastday' => [
                    0 => [
                        'date' => $this->getDate('2018-10-19'),
                        'wrong_date' => $this->getWrongDate('2018-10-19'),
                        'wrong_date_args' => $this->getWrongDate('2018-10-19'),
                        'day' => [
                            'avghumidity' => (object)34.4,
                            'condition' => [
                                'text' => null,
                            ],
                            'state' => 2,
                        ],
                        'astro' => [
                        ],
                        'astros' => [
                            0 => [
                                'sunrise' => '1AM',
                            ],
                            1 => [
                                'sunrise' => '2AM',
                            ],
                        ],
                    ],
                    1 => [
                        'date' => $this->getDate('2018-10-20'),
                        'wrong_date' => $this->getWrongDate('2018-10-19'),
                        'wrong_date_args' => $this->getWrongDate('2018-10-19'),
                        'day' => [
                            'avghumidity' => (object)34.4,
                            'condition' => [
                                'text' => null,
                            ],
                            'state' => 2,
                        ],
                        'astro' => [
                        ],
                        'astros' => [
                            0 => [
                                'sunrise' => '1AM',
                            ],
                            1 => [
                                'sunrise' => '2AM',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return [
            [
                $forecast,
                $expected,
            ],
            [
                new Collection([$forecast, $forecast]),
                [$expected, $expected,],
            ],
        ];
    }

    /**
     * @param string $date
     * @return DateTime
     * @throws Exception
     */
    protected function getDate(string $date)
    {
        return new DateTime($date);
    }

    /**
     * @param string $date
     * @return DateTime
     * @throws Exception
     */
    protected function getWrongDate(string $date)
    {
        return $this->getDate($date);
    }
}
