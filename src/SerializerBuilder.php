<?php

namespace Serializer;

use Serializer\Definition\Callback;
use Serializer\Definition\Property;
use Serializer\Definition\Type;
use Serializer\Format\FormatFactory;
use Serializer\Format\UnknownFormatException;
use Serializer\Parser\Parser;

class SerializerBuilder
{
    /**
     * @param Config $config
     * @return SerializerInterface
     * @throws UnknownFormatException
     */
    public static function build(Config $config)
    {
        $format = FormatFactory::get($config->getFormat());

        $definitions = [
            Property::class,
            Type::class,
            Callback::class,
        ];
        $parser = new Parser($definitions);

        return new Serializer($format, $parser);
    }
}
