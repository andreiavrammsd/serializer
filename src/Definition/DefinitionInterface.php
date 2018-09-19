<?php

namespace Serializer\Definition;

use Serializer\Parser\Model;
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
     * @param Model $model
     */
    public function setVariableValue($definition, Variable $variable, Model $model);
}
