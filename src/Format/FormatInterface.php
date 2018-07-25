<?php

namespace Serializer\Format;

interface FormatInterface
{
    /**
     * @param string $string
     * @return array
     */
    public function decode($string);
}
