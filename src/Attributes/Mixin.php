<?php

namespace Sven\LaravelMacroAttributes\Attributes;

use Attribute;
use Illuminate\Support\Traits\Macroable;

#[Attribute(Attribute::TARGET_CLASS)]
class Mixin
{
    public function __construct(public Macroable $target, public $replace = true)
    {
    }
}
