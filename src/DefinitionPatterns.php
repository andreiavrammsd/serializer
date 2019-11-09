<?php declare(strict_types=1);

namespace Serializer;

class DefinitionPatterns
{
    const DEFINITION = '#@Serializer\\\([a-z]+)\((.+)\)#i';
    const PROPERTY = '#@Serializer\\\Property\("(.+)"\)#i';
    const TYPE = '#@Serializer\\\Type\((.+)\)#i';
    const IGNORE_NULL = '@Serializer\IgnoreNull';
}
