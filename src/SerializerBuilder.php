<?php

namespace Serializer;

use Serializer\Definition\Callback;
use Serializer\Definition\Property;
use Serializer\Definition\Type;
use Serializer\Format\FormatFactory;
use Serializer\Format\FormatInterface;
use Serializer\Format\UnknownFormatException;
use Serializer\Parser\Parser;

class SerializerBuilder
{
    /**
     * @var FormatInterface
     */
    private $format;

    /**
     * @var array
     */
    private $definitions = [
        Property::class,
        Type::class,
        Callback::class,
    ];

    /**
     * @return SerializerBuilder
     * @throws UnknownFormatException
     */
    public static function instance()
    {
        return new static();
    }

    /**
     * @param string $format
     * @return $this
     * @throws UnknownFormatException
     */
    public function setFormat($format)
    {
        $this->format = FormatFactory::get($format);

        return $this;
    }

    /**
     * @param array $definitions
     * @return $this
     */
    public function setDefinitions(array $definitions)
    {
        $this->definitions = array_merge($this->definitions, $definitions);

        return $this;
    }

    /**
     * @return SerializerInterface
     */
    public function build()
    {
        $parser = new Parser($this->definitions);

        return new Serializer($this->format, $parser);
    }
}
