<?php declare(strict_types = 1);

namespace Serializer\Tests;

use PHPUnit\Framework\TestCase;
use Serializer\Factory;
use Serializer\Format\UnknownFormatException;
use Serializer\SerializerException;
use Serializer\SerializerInterface;

class FactoryTest extends TestCase
{
    public function testCreate()
    {
        $serializer = Factory::create();
        $this->assertInstanceOf(SerializerInterface::class, $serializer);
    }

    public function testCreateWithUnknownFormat()
    {
        try {
            Factory::create('');
            $this->fail('No exception was thrown');
        } catch (\Exception $e) {
            $this->assertInstanceOf(SerializerException::class, $e);
            $this->assertInstanceOf(UnknownFormatException::class, $e);
        }
    }
}
