<?php

namespace Cove\MacroAttributes\Tests\Cases;

use Cove\MacroAttributes\Attributes\Mixin as MixinAttribute;

#[MixinAttribute(MacroableStub::class, replace: true)]
class Mixin
{
    public function testMixinMethod(): callable
    {
        return fn () => '::mixin-test::';
    }
}
