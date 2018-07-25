<?php

namespace Serializer\Format;

class FormatFactory
{
    /**
     * @param string $format
     * @return FormatInterface
     * @throws \Exception
     */
    public static function get($format)
    {
        switch ($format) {
            case 'json':
                return new JsonFormat();
            default:
                throw new \Exception(sprintf('Unknown format: %s', $format));
        }
    }
}
