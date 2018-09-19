<?php

namespace Serializer\Parser;

interface ParserInterface
{
    /**
     * @param mixed $data
     * @param string $class
     * @return mixed
     */
    public function parse($data, $class);
}
