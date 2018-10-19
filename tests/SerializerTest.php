<?php declare(strict_types = 1);

namespace Serializer\Tests;

use PHPUnit\Framework\TestCase;
use Serializer\Format\FormatInterface;
use Serializer\ObjectToArray\ObjectToArrayInterface;
use Serializer\Parser\ParserInterface;
use Serializer\Serializer;
use Serializer\Tests\Data\Person;

class SerializerTest extends TestCase
{
    private $format;
    private $parser;
    private $objectToArray;

    protected function setUp()
    {
        $this->format = $this->createMock(FormatInterface::class);
        $this->parser = $this->createMock(ParserInterface::class);
        $this->objectToArray = $this->createMock(ObjectToArrayInterface::class);
    }

    public function testUnserialize()
    {
        $input = '{}';
        $array = [];
        $class = Person::class;
        $expected = new Person();

        $this->format->expects($this->once())
            ->method('decode')
            ->with($input)
            ->will($this->returnValue($array));
        $this->parser->expects($this->once())
            ->method('parse')
            ->with($array)
            ->will($this->returnValue($expected));
        $serializer = new Serializer($this->format, $this->parser, $this->objectToArray);

        $object = $serializer->unserialize($input, $class);
        $this->assertEquals($expected, $object);
    }

    public function testToArray()
    {
        $input = new Person();
        $expected = [];

        $this->objectToArray->expects($this->once())
            ->method('toArray')
            ->with($input)
            ->will($this->returnValue($expected));
        $serializer = new Serializer($this->format, $this->parser, $this->objectToArray);

        $array = $serializer->toArray($input);
        $this->assertEquals($expected, $array);
    }
}
