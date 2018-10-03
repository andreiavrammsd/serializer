<?php

namespace Serializer\ToArray;

interface ToArrayInterface
{
    /**
     * Returns the array representation of the class
     *
     * If the array has no elements, null will be returned to indicate this.
     *
     * @return array|null
     */
    public function toArray() : ?array;
}
