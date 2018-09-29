<?php declare(strict_types = 1);

namespace Serializer\Parser;

class Variable
{
    /**
     * @var \ReflectionProperty
     */
    private $property;

    /**
     * @var mixed
     */
    private $object;

    /**
     * @param \ReflectionProperty $property
     * @param mixed $object
     */
    public function __construct(\ReflectionProperty $property, $object)
    {
        $this->property = $property;
        $this->property->setAccessible(true);
        $this->object = $object;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->property->setValue($this->object, $value);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->property->getValue($this->object);
    }
}
