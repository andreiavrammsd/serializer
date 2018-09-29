<?php declare(strict_types = 1);

namespace Serializer\Tests\Format;

use PHPUnit\Framework\TestCase;
use Serializer\Format\FormatFactory;
use Serializer\Format\FormatInterface;
use Serializer\Format\UnknownFormatException;
use Serializer\SerializerException;

class FormatFactoryTest extends TestCase
{
    public function testGet()
    {
        $format = FormatFactory::get('json');
        $this->assertInstanceOf(FormatInterface::class, $format);
    }

    public function testGetWithUnknownFormat()
    {
        try {
            FormatFactory::get('unknown');
            $this->fail('No exception was thrown');
        } catch (\Exception $e) {
            $this->assertInstanceOf(SerializerException::class, $e);
            $this->assertInstanceOf(UnknownFormatException::class, $e);
        }
    }
}
