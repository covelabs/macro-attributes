<?php

namespace Cove\MacroAttributes\Attributes;

use Attribute;
use Cove\MacroAttributes\Exceptions\MustBeMacroable;
use Illuminate\Support\Traits\Macroable;

#[Attribute(Attribute::TARGET_CLASS)]
final class Mixin
{
    /**
     * @param class-string<\Illuminate\Support\Traits\Macroable> $target
     * @param bool $replace
     */
    public function __construct(public string $target, public bool $replace = true)
    {
        if (!in_array(Macroable::class, class_uses_recursive($target), strict: true)) {
            throw MustBeMacroable::from($target);
        }
    }
}
