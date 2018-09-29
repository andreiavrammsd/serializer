<?php declare(strict_types = 1);

namespace Serializer\Handlers\Property;

use Serializer\Parser\Variable;

class Callback implements PropertyHandlerInterface
{
    const CLASS_CALLBACK_PATTERN = '#\[(.*),(.*)\]#';

    /**
     * {@inheritdoc}
     */
    public function getDefinition($data)
    {
        $matches = preg_match_all(Type::ARGUMENTS_PATTERN, $data, $args);
        $args = $matches !== false ? $args[1] : [];
        $name = $this->getCallable(array_shift($args));

        return [
            'name' => $name,
            'args' => $args,
        ];
    }

    /**
     * @param string $callback
     * @return array|string
     */
    private function getCallable(string $callback)
    {
        $match = preg_match(self::CLASS_CALLBACK_PATTERN, $callback, $args);
        if (!$match) {
            return $callback;
        }

        $class = trim($args[1]);
        $method = trim($args[2]);

        return [
            new $class,
            $method,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setVariableValue($definition, Variable $variable, array $data)
    {
        array_unshift($definition['args'], $variable->getValue());
        $variable->setValue(call_user_func_array($definition['name'], $definition['args']));
    }
}
