<?php declare(strict_types = 1);

namespace Serializer;

use Serializer\Definition\Callback;
use Serializer\Definition\Property;
use Serializer\Definition\Type;
use Serializer\Format\FormatFactory;
use Serializer\Format\FormatInterface;
use Serializer\Format\UnknownFormatException;
use Serializer\Parser\Parser;

final class SerializerBuilder
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
    public static function instance() : SerializerBuilder
    {
        return new static();
    }

    /**
     * @param string $format
     * @return $this
     * @throws UnknownFormatException
     */
    public function setFormat(string $format)
    {
        $this->format = FormatFactory::get($format);

        return $this;
    }

    /**
     * @param array $definitions
     * @return SerializerBuilder
     */
    public function setDefinitions(array $definitions) : SerializerBuilder
    {
        $this->definitions = array_merge($this->definitions, $definitions);

        return $this;
    }

    /**
     * @return SerializerInterface
     */
    public function build() : SerializerInterface
    {
        $parser = new Parser();
        foreach ($this->definitions as $class) {
            $parser->registerDefinitionHandler(new $class($parser));
        }

        return new Serializer($this->format, $parser);
    }
}
