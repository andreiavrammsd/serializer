<?php declare(strict_types = 1);

namespace Serializer\Format;

final class FormatFactory
{
    /**
     * @param string $format
     * @return FormatInterface
     * @throws UnknownFormatException
     */
    public static function get(string $format)
    {
        switch ($format) {
            case 'json':
                return new JsonFormat();
            default:
                throw new UnknownFormatException(sprintf('Unknown format: %s', $format));
        }
    }
}
