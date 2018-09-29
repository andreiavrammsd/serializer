<?php declare(strict_types = 1);

namespace Serializer\Tests\Format;

use PHPUnit\Framework\TestCase;
use Serializer\Format\FormatFactory;
use Serializer\Format\InvalidInputException;
use Serializer\SerializerException;

class JsonFormatTest extends TestCase
{
    public function testDecode()
    {
        $format = FormatFactory::get('json');
        $result = $format->decode('{"a": 1}');
        $this->assertSame(['a' => 1], $result);
    }

    public function testInvalidInput()
    {
        try {
            $format = FormatFactory::get('json');
            $format->decode('{invalid json}');
            $this->fail('No exception was thrown');
        } catch (\Exception $e) {
            $this->assertInstanceOf(SerializerException::class, $e);
            $this->assertInstanceOf(InvalidInputException::class, $e);
        }
    }
}
