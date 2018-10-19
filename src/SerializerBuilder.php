<?php declare(strict_types = 1);

namespace Serializer;

use Serializer\Format\FormatFactory;
use Serializer\Format\UnknownFormatException;
use Serializer\Handlers\Object\Collection;
use Serializer\Handlers\Property\Callback;
use Serializer\Handlers\Property\Property;
use Serializer\Handlers\Property\Type;
use Serializer\ObjectToArray\ObjectToArray;
use Serializer\Parser\Parser;

final class SerializerBuilder
{
    const DEFAULT_FORMAT = 'json';

    /**
     * @var string
     */
    private $format = self::DEFAULT_FORMAT;

    /**
     * @var array
     */
    private $objectHandlers = [
        Collection::class,
    ];

    /**
     * @var array
     */
    private $propertyHandlers = [
        Property::class,
        Type::class,
        Callback::class,
    ];

    /**
     * @return SerializerBuilder
     */
    public static function instance() : SerializerBuilder
    {
        return new static();
    }

    /**
     * @param string $format
     * @return $this
     */
    public function setFormat(string $format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * @param array $handlers
     * @return SerializerBuilder
     */
    public function setObjectHandlers(array $handlers) : SerializerBuilder
    {
        $this->objectHandlers = array_merge($this->objectHandlers, $handlers);

        return $this;
    }

    /**
     * @param array $handlers
     * @return SerializerBuilder
     */
    public function setPropertyHandlers(array $handlers) : SerializerBuilder
    {
        $this->propertyHandlers = array_merge($this->propertyHandlers, $handlers);

        return $this;
    }

    /**
     * @return SerializerInterface
     * @throws UnknownFormatException
     */
    public function build() : SerializerInterface
    {
        $format = FormatFactory::get($this->format);

        $parser = new Parser();
        foreach ($this->objectHandlers as $class) {
            $parser->registerObjectHandler(new $class($parser));
        }
        foreach ($this->propertyHandlers as $class) {
            $parser->registerPropertyHandler(new $class($parser));
        }

        $objectToArray = new ObjectToArray();

        return new Serializer($format, $parser, $objectToArray);
    }
}
