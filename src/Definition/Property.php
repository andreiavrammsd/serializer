<?php

namespace Serializer\Definition;

use Serializer\Model;
use Serializer\Variable;

class Property implements DefinitionInterface
{
    public function getDefinition($data)
    {
        return trim($data, '" ');
    }

    public function setVariableValue($definition, Variable $variable, Model $model)
    {
        $data = $model->getData();
        if (array_key_exists($definition, $data)) {
            $variable->setValue($data[$definition]);
        }
    }
}
