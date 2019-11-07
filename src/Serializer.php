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
     * @var ObjectToArrayInterface|null
     */
    private $objectToArrayFormat;

    /**
     * @param FormatInterface $format
     * @param ParserInterface $parser
     * @param ObjectToArrayInterface $objectToArray
     * @param ObjectToArrayInterface|null $objectToArrayFormat
     */
    public function __construct(
        FormatInterface $format,
        ParserInterface $parser,
        ObjectToArrayInterface $objectToArray,
        ObjectToArrayInterface $objectToArrayFormat = null
    ) {
        $this->format = $format;
        $this->parser = $parser;
        $this->objectToArray = $objectToArray;
        $this->objectToArrayFormat = $objectToArrayFormat;
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
     * @throws SerializerException
     */
    public function serialize($object) : string
    {
        if ($this->objectToArrayFormat === null) {
            throw new SerializerException('objectToArrayFormat not set');
        }

        $array = $this->objectToArrayFormat->toArray($object);

        return $this->format->encode($array);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray($object) : array
    {
        return $this->objectToArray->toArray($object);
    }
}
