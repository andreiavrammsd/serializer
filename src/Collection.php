<?php

namespace Serializer;

class Collection implements \Iterator, \Countable
{
    /**
     * @var int
     */
    private $index = 0;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->data[$this->index];
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {

        return $this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {

        ++$this->index;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return array_key_exists($this->index, $this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->data);
    }
}
