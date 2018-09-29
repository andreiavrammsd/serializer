<?php

namespace Serializer\Tests\Callback;

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
