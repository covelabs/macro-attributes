<?php

namespace Cove\MacroAttributes\Attributes;

use Attribute;
use Illuminate\Support\Traits\Macroable;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
final class Macro
{
    public function __construct(public Macroable $target)
    {
    }
}
