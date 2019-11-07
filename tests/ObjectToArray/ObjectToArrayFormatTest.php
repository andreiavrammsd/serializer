<?php declare(strict_types = 1);

namespace Serializer\Tests\ObjectToArray;

use ReflectionException;
use Serializer\ObjectToArray\ObjectToArrayFormat;
use Serializer\ObjectToArray\ObjectToArrayInterface;

class ObjectToArrayFormatTest extends ObjectToArrayTest
{
    /**
     * @var ObjectToArrayInterface
     */
    private $toArray;

    protected function setUp()
    {
        $this->toArray = new ObjectToArrayFormat();
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
     * @param string $date
     * @return string
     */
    protected function getDate(string $date)
    {
        return $date;
    }

    /**
     * @param string $date
     * @return string
     */
    protected function getWrongDate(string $date)
    {
        return $date . ' 00:00:00 UTC';
    }
}
