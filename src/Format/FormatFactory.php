<?php

namespace Serializer\Format;

class FormatFactory
{
    /**
     * @param string $format
     * @return FormatInterface
     * @throws UnknownFormatException
     */
    public static function get($format)
    {
        switch ($format) {
            case 'json':
                return new JsonFormat();
            default:
                throw new UnknownFormatException(sprintf('Unknown format: %s', $format));
        }
    }
}
