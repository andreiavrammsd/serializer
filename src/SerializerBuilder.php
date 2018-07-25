<?php

namespace Serializer;

use Serializer\CustomType\CustomTypeHandler;
use Serializer\Format\FormatFactory;
use Serializer\Definition\Property;
use Serializer\Definition\Type;
use Serializer\Definition\Callback;

class SerializerBuilder
{
    /**
     * @param string $format
     * @return Serializer
     * @throws \Exception
     */
    public static function build($format)
    {
        $format = FormatFactory::get($format);
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
