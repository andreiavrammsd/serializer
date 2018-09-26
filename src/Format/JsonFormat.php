<?php

namespace Serializer\Format;

final class JsonFormat implements FormatInterface
{
    /**
     * {@inheritdoc}
     */
    public function decode($string)
    {
        return json_decode($string, true);
    }
}
