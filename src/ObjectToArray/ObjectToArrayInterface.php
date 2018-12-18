<?php

namespace Serializer\ObjectToArray;

interface ObjectToArrayInterface
{
    /**
     * Returns the array representation of the class
     *
     * @param object $object
     * @return array
     */
    public function toArray($object) : array;
}
