<?php declare(strict_types = 1);

namespace Serializer\Handlers;

interface HandlerInterface
{
    /**
     * @param mixed $data
     * @return array|string
     */
    public function getDefinition($data);
}
