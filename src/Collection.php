<?php

namespace Serializer;

class Collection implements \Iterator, \Countable
{
    private $index = 0;
    private $data = array();

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function rewind()
    {

        $this->index = 0;
    }

    public function current()
    {
        return $this->data[$this->index];
    }

    public function key()
    {

        return $this->index;
    }

    public function next()
    {

        ++$this->index;
    }

    public function valid()
    {
        return array_key_exists($this->index, $this->data);
    }

    public function count()
    {
        return count($this->data);
    }
}
