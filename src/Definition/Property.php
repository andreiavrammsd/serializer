<?php

namespace Serializer\Definition;

use Serializer\Parser\Model;
use Serializer\Parser\Variable;

class Property implements DefinitionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition($data)
    {
        return trim($data, '" ');
    }

    /**
     * {@inheritdoc}
     */
    public function setVariableValue($definition, Variable $variable, Model $model)
    {
        $data = $model->getData();
        if (array_key_exists($definition, $data)) {
            $variable->setValue($data[$definition]);
        }
    }
}
