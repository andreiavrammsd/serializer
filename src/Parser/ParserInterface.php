<?php

namespace Serializer\Parser;

use Serializer\Definition\DefinitionInterface;

interface ParserInterface
{
    /**
     * @param DefinitionInterface $handler
     */
    public function registerDefinitionHandler(DefinitionInterface $handler);

    /**
     * @param mixed $data
     * @param string $class
     * @return mixed
     */
    public function parse($data, $class);
}
