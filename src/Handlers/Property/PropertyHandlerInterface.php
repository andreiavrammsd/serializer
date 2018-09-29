<?php declare(strict_types = 1);

namespace Serializer\Handlers\Property;

use Serializer\Handlers\HandlerInterface;
use Serializer\Parser\Variable;

interface PropertyHandlerInterface extends HandlerInterface
{
    const ARGUMENTS_PATTERN = '#"(.*?)"#';

    /**
     * @param mixed $definition
     * @param Variable $variable
     * @param array $data
     */
    public function setVariableValue($definition, Variable $variable, array $data);
}
