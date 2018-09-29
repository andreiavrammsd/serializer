<?php declare(strict_types = 1);

namespace Serializer\Parser;

use Serializer\Handlers\Object\ObjectHandlerInterface;
use Serializer\Handlers\Property\PropertyHandlerInterface;

interface ParserInterface
{
    /**
     * @param ObjectHandlerInterface $handler
     */
    public function registerObjectHandler(ObjectHandlerInterface $handler);

    /**
     * /**
     * @param PropertyHandlerInterface $handler
     */
    public function registerPropertyHandler(PropertyHandlerInterface $handler);

    /**
     * @param array $data
     * @param string $class
     * @return mixed
     */
    public function parse(array $data, string $class);
}
