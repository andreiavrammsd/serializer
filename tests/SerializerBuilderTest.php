<?php declare(strict_types = 1);

namespace Serializer\Tests;

use PHPUnit\Framework\TestCase;
use Serializer\Format\UnknownFormatException;
use Serializer\SerializerBuilder;
use Serializer\SerializerException;
use Serializer\SerializerInterface;

class SerializerBuilderTest extends TestCase
{
    public function testBuild()
    {
        $serializer = SerializerBuilder::instance()
            ->setFormat('json')
            ->setObjectHandlers([
                \Serializer\Handlers\Object\Collection::class,
            ])
            ->setPropertyHandlers([
                \Serializer\Handlers\Property\Type::class,
            ])
            ->build();

        $this->assertInstanceOf(SerializerInterface::class, $serializer);
    }

    public function testBuildWithUnknownFormat()
    {
        try {
            SerializerBuilder::instance()
                ->setFormat('unknown')
                ->build();
            $this->fail('No exception was thrown');
        } catch (\Exception $e) {
            $this->assertInstanceOf(SerializerException::class, $e);
            $this->assertInstanceOf(UnknownFormatException::class, $e);
        }
    }
}
