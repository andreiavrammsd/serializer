<?php

namespace Serializer;

use Serializer\Format\FormatInterface;
use Serializer\Parser\ParserInterface;

class Serializer implements SerializerInterface
{
    /**
     * @var FormatInterface
     */
    private $format;

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @param FormatInterface $format
     * @param ParserInterface $parser
     */
    public function __construct(FormatInterface $format, ParserInterface $parser)
    {
        $this->format = $format;
        $this->parser = $parser;
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($input, $class)
    {
        $data = $this->format->decode($input);

        return $this->parser->parse($data, $class);
    }
}
