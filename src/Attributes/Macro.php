<?php

namespace Cove\MacroAttributes\Attributes;

use Attribute;
use Cove\MacroAttributes\Exceptions\MustBeMacroable;
use Illuminate\Support\Traits\Macroable;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final class Macro
{
    /**
     * @param class-string<\Illuminate\Support\Traits\Macroable> $target
     */
    public function __construct(public string $target)
    {
        if (!in_array(Macroable::class, class_uses_recursive($target), strict: true)) {
            throw MustBeMacroable::from($target);
        }
    }
}
