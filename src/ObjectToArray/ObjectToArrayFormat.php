<?php

namespace Serializer\ObjectToArray;

use DateTime;
use Serializer\DefinitionPatterns;
use Serializer\Handlers\Property\Type;

class ObjectToArrayFormat extends ObjectToArray
{
    const DEFAULT_DATETIME_FORMAT = 'Y-m-d H:i:s e';

    /**
     * @param mixed $value
     * @param string|null $doc
     * @return mixed
     */
    protected function formatValue($value, string $doc = null)
    {
        if ($value instanceof DateTime) {
            return $this->formatDateTime($value, (string)$doc);
        }

        return $value;
    }

    /**
     * @param DateTime $dateTime
     * @param string $doc
     * @return string
     */
    private function formatDateTime(DateTime $dateTime, string $doc): string
    {
        $format = self::DEFAULT_DATETIME_FORMAT;

        $matches = [];
        if (preg_match_all(DefinitionPatterns::TYPE, $doc, $matches)) {
            $argsList = $matches[1][0];

            $args = [];
            if (preg_match_all(Type::ARGUMENTS_PATTERN, $argsList, $args)) {
                $type = $args[1][0];

                if ($type == 'DateTime') {
                    $format = $args[1][1] ?? '';
                }
            }
        }

        return $dateTime->format($format);
    }
}
