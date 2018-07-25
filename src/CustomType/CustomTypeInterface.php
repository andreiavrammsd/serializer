<?php

namespace Serializer\CustomType;

interface CustomTypeInterface
{
    /**
     * @param mixed $input
     * @return mixed
     */
    public function getValue($input);
}
