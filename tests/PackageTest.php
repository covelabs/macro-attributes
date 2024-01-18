<?php

namespace Cove\MacroAttributes\Tests;

use Cove\MacroAttributes\Tests\Cases\MacroableStub;
use PHPUnit\Framework\Attributes\Test;

class PackageTest extends TestCase
{
    #[Test]
    public function it_adds_a_macro_to_a_class(): void
    {
        $stub = new MacroableStub();

        self::assertSame('::macro-test::', $stub->testMacroMethod());
    }

    #[Test]
    public function it_mixes_in_a_class(): void
    {
        $stub = new MacroableStub();

        self::assertSame('::mixin-test::', $stub->testMixinMethod());
    }
}
