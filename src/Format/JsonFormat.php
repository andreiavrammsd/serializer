<?php

namespace Serializer\Format;

final class JsonFormat implements FormatInterface
{
    /**
     * {@inheritdoc}
     */
    public function decode(string $string)
    {
        $result = json_decode($string, true);

        $err = json_last_error();
        if ($err !== JSON_ERROR_NONE) {
            throw new InvalidInputException(json_last_error_msg(), $err);
        }

        return $result;
    }
}
