<?php

use Cove\MacroAttributes\Attributes\Macro;
use Cove\MacroAttributes\Tests\Cases\MacroableStub;

#[Macro(MacroableStub::class)]
function testMacroFunction() {
    return '::function-macro-test::';
}
