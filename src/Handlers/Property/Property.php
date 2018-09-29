<?php declare(strict_types = 1);

namespace Serializer\Handlers\Property;

use Serializer\Parser\Variable;

class Property implements PropertyHandlerInterface
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
    public function setVariableValue($definition, Variable $variable, array $data)
    {
        if (array_key_exists($definition, $data)) {
            $variable->setValue($data[$definition]);
        }
    }
}
