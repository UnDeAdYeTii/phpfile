<?php

namespace YeTii\PhpFile\Tests\Formatter;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Schema\PhpMethod;
use YeTii\PhpFile\Entity\Visibility;
use YeTii\PhpFile\Schema\PhpArgument;
use YeTii\PhpFile\Entity\TypeDeclaration;
use YeTii\PhpFile\Formatter\MethodFormatter;

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
