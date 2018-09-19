<?php

namespace Serializer;

interface SerializerInterface
{
    /**
     * Converts input string into given class object.
     *
     * @param string $input
     * @param string $class
     * @return mixed
     */
    public function unserialize($input, $class);
}
