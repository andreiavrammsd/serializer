<?php declare(strict_types = 1);

namespace Serializer;

use Serializer\Format\UnknownFormatException;

final class Factory
{
    /**
     * Creates Serializer instance by format
     *
     * @param string $format
     * @return SerializerInterface
     * @throws UnknownFormatException
     */
    public static function create(string $format = SerializerBuilder::DEFAULT_FORMAT) : SerializerInterface
    {
        return SerializerBuilder::instance()->setFormat($format)->build();
    }
}
