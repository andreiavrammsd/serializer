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
     * @param array $data
     * @param string $class
     * @return mixed
     */
    public function parse(array $data, $class);
}
