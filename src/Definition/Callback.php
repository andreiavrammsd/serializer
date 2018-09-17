<?php

namespace Serializer\Definition;

use Serializer\Model;
use Serializer\Variable;

class Callback implements DefinitionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition($data)
    {
        $re = preg_match_all(Type::ARGUMENTS_PATTERN, $data, $args);
        $args = $re !== false ? $args[1] : [];
        $name = array_shift($args);
        return ['name' => $name, 'args' => $args];
    }

    /**
     * {@inheritdoc}
     */
    public function setVariableValue($definition, Variable $variable, Model $model)
    {
        array_unshift($definition['args'], $variable->getValue());
        $variable->setValue(call_user_func_array($definition['name'], $definition['args']));
    }
}
