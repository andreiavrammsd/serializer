<?php

namespace Serializer\Parser;

class Model
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $class;

    /**
     * @param array $data
     * @param string $class
     */
    public function __construct(array $data, $class)
    {
        $this->data = $data;
        $this->class = $class;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }
}
