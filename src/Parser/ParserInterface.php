<?php declare(strict_types = 1);

namespace Serializer\Parser;

use Serializer\Handlers\Object\ObjectHandlerInterface;
use Serializer\Handlers\Property\PropertyHandlerInterface;

interface ParserInterface
{
    const DEFINITION_PATTERN = '#@Serializer\\\([a-z]+)\((.+)\)#i';
    const PROPERTY_DEFINITION_PATTERN = '#@Serializer\\\Property\((.+)\)#i';

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
