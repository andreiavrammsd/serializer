<?php

namespace Serializer\Format;

interface FormatInterface
{
    /**
     * @param string $string
     * @return array
     * @throws InvalidInputException
     */
    public function decode($string);
}
