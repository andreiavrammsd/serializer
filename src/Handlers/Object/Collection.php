<?php declare(strict_types = 1);

namespace Serializer\Handlers\Object;

use Serializer\Parser\ParserInterface;

class Collection implements ObjectHandlerInterface
{
    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefinition($data)
    {
        return trim($data, '" ');
    }

    /**
     * {@inheritdoc}
     */
    public function setObject($definition, $object, array $data)
    {
        /** @var \Serializer\Collection $object */
        foreach ($data as $k => $v) {
            $object[$k] = $this->parser->parse($v, $definition);
        }
    }
}
