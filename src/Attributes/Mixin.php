<?php

namespace Cove\MacroAttributes\Attributes;

use Attribute;
use Illuminate\Support\Traits\Macroable;

#[Attribute(Attribute::TARGET_CLASS)]
final class Mixin
{
    public function __construct(public Macroable $target, public bool $replace = true)
    {
    }
}
