<?php

namespace Sven\LaravelMacroAttributes\Attributes;

use Attribute;
use Illuminate\Support\Traits\Macroable;

#[Attribute(Attribute::TARGET_CLASS)]
final class Mixin
{
    public function __construct(public Macroable $target, public $replace = true)
    {
    }
}
