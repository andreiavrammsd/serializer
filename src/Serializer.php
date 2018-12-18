<?php declare(strict_types = 1);

namespace Serializer;

use Serializer\Format\FormatInterface;
use Serializer\ObjectToArray\ObjectToArrayInterface;
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
     * @var ObjectToArrayInterface
     */
    private $objectToArray;

    /**
     * @param FormatInterface $format
     * @param ParserInterface $parser
     * @param ObjectToArrayInterface $objectToArray
     */
    public function __construct(
        FormatInterface $format,
        ParserInterface $parser,
        ObjectToArrayInterface $objectToArray
    ) {
        $this->format = $format;
        $this->parser = $parser;
        $this->objectToArray = $objectToArray;
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize(string $input, string $class)
    {
        $data = $this->format->decode($input);

        return $this->parser->parse($data, $class);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($object) : array
    {
        return $this->objectToArray->toArray($object);
    }
}
