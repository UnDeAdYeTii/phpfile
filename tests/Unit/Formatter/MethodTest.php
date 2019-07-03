<?php

namespace YeTii\PhpFile\Tests\Unit\Formatter;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Schemas\PhpMethod;
use YeTii\PhpFile\Entities\Visibility;
use YeTii\PhpFile\Schemas\PhpArgument;
use YeTii\PhpFile\Entities\TypeDeclaration;
use YeTii\PhpFile\Formatters\MethodFormatter;

final class MethodTest extends TestCase
{
    /** @test */
    public function itCanFormatAValidEmptyMethod(): void
    {
        $visibility = new Visibility('public');
        $constant = new PhpMethod('method', $visibility, null, null);

        $propertyFormatter = new MethodFormatter($constant);

        $this->assertEquals(<<<'PHP'
    public function method() {
        
    }
PHP
            , $propertyFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidMethodWithArguments(): void
    {
        $visibility = new Visibility('public');
        $arguments = [new PhpArgument('argument', new TypeDeclaration(null), null, false)];
        $constant = new PhpMethod('method', $visibility, null, $arguments);

        $propertyFormatter = new MethodFormatter($constant);

        $this->assertEquals(<<<'PHP'
    public function method($argument) {
        
    }
PHP
            , $propertyFormatter->format());
    }
}
