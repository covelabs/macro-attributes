<?php

namespace Cove\MacroAttributes\Tests\Cases;

use Illuminate\Support\Traits\Macroable;

class MacroableStub
{
    use Macroable;

    public function actualMethod(): string
    {
        return '::actual-method::';
    }
}
