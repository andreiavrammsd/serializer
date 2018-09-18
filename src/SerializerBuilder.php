<?php

namespace Serializer;

use Serializer\CustomType\CustomTypeHandler;
use Serializer\Definition\Callback;
use Serializer\Definition\Property;
use Serializer\Definition\Type;
use Serializer\Format\FormatFactory;
use Serializer\Format\UnknownFormatException;

class SerializerBuilder
{
    /**
     * @param Config $config
     * @return Serializer
     * @throws UnknownFormatException
     */
    public static function build(Config $config)
    {
        $format = FormatFactory::get($config->getFormat());
        $customTypeHandler = new CustomTypeHandler();
        $definitions = [
            Property::class,
            Type::class,
            Callback::class,
        ];

        $serializer = new Serializer($format, $customTypeHandler);
        foreach ($definitions as $definition) {
            $serializer->registerDefinitionHandler($definition);
        }

        return $serializer;
    }
}
