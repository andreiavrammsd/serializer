<?php

namespace Serializer\Definition;

use Serializer\Parser\Variable;

interface DefinitionInterface
{
    const ARGUMENTS_PATTERN = '#"(.*?)"#';

    /**
     * @param mixed $data
     * @return array|string
     */
    public function getDefinition($data);

    /**
     * @param mixed $definition
     * @param Variable $variable
     * @param array $data
     */
    public function setVariableValue($definition, Variable $variable, array $data);
}
