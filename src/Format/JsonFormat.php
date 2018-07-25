<?php

namespace Serializer\Format;

class JsonFormat implements FormatInterface
{
    /**
     * {@inheritdoc}
     */
    public function decode($string)
    {
        return json_decode($string, true);
    }
}
