<?php

namespace Serializer\CustomType;

class Boolean implements CustomTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getValue($input)
    {
        return $input !== null ? !empty($input) : null;
    }
}
