<?php

namespace Sven\LaravelMacroAttributes\Attributes;

use Attribute;
use Illuminate\Support\Traits\Macroable;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_FUNCTION)]
class Macro
{
    public function __construct(public Macroable $target)
    {
    }
}
