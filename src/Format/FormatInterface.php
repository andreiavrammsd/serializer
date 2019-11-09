<?php declare(strict_types=1);

namespace Serializer\Format;

interface FormatInterface
{
    /**
     * @param string $string
     * @return array
     * @throws InvalidInputException
     */
    public function decode(string $string);

    /**
     * @param mixed $object
     * @return string
     * @throws InvalidInputException
     */
    public function encode($object): string;
}
