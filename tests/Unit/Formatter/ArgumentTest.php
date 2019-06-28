<?php

namespace YeTii\PhpFile\Tests\Formatter;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Schema\PhpArgument;
use YeTii\PhpFile\Entity\TypeDeclaration;
use YeTii\PhpFile\Formatter\ArgumentFormatter;

final class ArgumentTest extends TestCase
{
    /** @test */
    public function itCanFormatAValidEmptyArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('string');
        $argument = new PhpArgument('argument', $typeDeclaration, null, false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('string argument', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidStringArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('string');
        $argument = new PhpArgument('argument', $typeDeclaration, "''", false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('string argument = \'\'', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidArrayArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('array');
        $argument = new PhpArgument('argument', $typeDeclaration, '[]', false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('array argument = []', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatANullArgument(): void
    {
        $typeDeclaration = new TypeDeclaration(null);
        $argument = new PhpArgument('argument', $typeDeclaration, 'null', false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('argument = null', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatAReferenceArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('string');
        $argument = new PhpArgument('argument', $typeDeclaration, "''", true);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('string &argument = \'\'', $argumentFormatter->format());
    }
}
