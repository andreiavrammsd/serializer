<?php

namespace Serializer\CustomType;

class CustomTypeHandler
{
    /**
     * @param string $class
     * @return bool
     */
    public function isCustomType($class)
    {
        $implements = class_implements($class);

        return isset($implements[CustomTypeInterface::class]);
    }

    /**
     * @param string $class
     * @param array $args
     * @param mixed $data
     * @return mixed
     */
    public function getValue($class, array $args, $data)
    {
        /** @var CustomTypeInterface $object */
        $object = new $class(...$args);

        return $object->getValue($data);
    }
}
