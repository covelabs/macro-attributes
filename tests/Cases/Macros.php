<?php

namespace Cove\MacroAttributes\Tests\Cases;

use Cove\MacroAttributes\Attributes\Macro;

class Macros
{
    #[Macro(MacroableStub::class)]
    public function testMacroMethod(): callable
    {
        return fn () => '::macro-test::';
    }
}
