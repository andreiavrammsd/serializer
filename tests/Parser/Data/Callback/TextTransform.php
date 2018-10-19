<?php

namespace Serializer\Tests\Parser\Data\Callback;

class TextTransform
{
    public function toName($input, $minLength)
    {
        if (strlen($input) >= $minLength) {
            return ucwords(strtolower($input));
        }

        return $input;
    }
}
