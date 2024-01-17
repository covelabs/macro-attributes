<?php

namespace Cove\MacroAttributes\Exceptions;

use InvalidArgumentException;

class MustBeMacroable extends InvalidArgumentException
{
    public static function from(string $class): self
    {
        return new self('Class "'.$class.'" must be macroable.');
    }
}
