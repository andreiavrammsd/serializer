<?php declare(strict_types = 1);

namespace Serializer\Handlers\Object;

use Serializer\Handlers\HandlerInterface;

interface ObjectHandlerInterface extends HandlerInterface
{
    /**
     * @param mixed $definition
     * @param object $object
     * @param array $data
     */
    public function setObject($definition, $object, array $data);
}
