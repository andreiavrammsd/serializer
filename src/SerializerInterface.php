<?php declare(strict_types=1);

namespace Serializer;

use Serializer\Format\InvalidInputException;

interface SerializerInterface
{
    /**
     * Converts input string into given class object
     *
     * @param string $input
     * @param string $class
     * @return mixed
     * @throws InvalidInputException
     */
    public function unserialize(string $input, string $class);

    /**
     * Converts object to string representation
     *
     * @param mixed $object
     * @return string
     * @throws InvalidInputException
     */
    public function serialize($object): string;

    /**
     * Converts input object to array
     *
     * @param object $object
     * @return array
     */
    public function toArray($object): array;
}
