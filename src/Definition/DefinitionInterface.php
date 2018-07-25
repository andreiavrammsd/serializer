<?php

namespace Serializer\Definition;

use Serializer\Model;
use Serializer\Variable;

interface DefinitionInterface
{
    const ARGUMENTS_PATTERN = '#"(.*?)"#';

    /**
     * @param mixed $data
     * @return array
     */
    public function getDefinition($data);

    /**
     * @param mixed $definition
     * @param Variable $variable
     * @param Model $model
     */
    public function setVariableValue($definition, Variable $variable, Model $model);
}
