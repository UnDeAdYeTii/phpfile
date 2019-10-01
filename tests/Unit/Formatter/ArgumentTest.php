<?php

namespace YeTii\PhpFile\Tests\Unit\Formatter;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Schemas\PhpArgument;
use YeTii\PhpFile\Entities\TypeDeclaration;
use YeTii\PhpFile\Formatters\ArgumentFormatter;

final class ArgumentTest extends TestCase
{
    /** @test */
    public function itCanFormatAValidEmptyArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('string');
        $argument = new PhpArgument('argument', $typeDeclaration, null, false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('string $argument', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidStringArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('string');
        $argument = new PhpArgument('argument', $typeDeclaration, "''", false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('string $argument = \'\'', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidArrayArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('array');
        $argument = new PhpArgument('argument', $typeDeclaration, '[]', false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('array $argument = []', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatANullArgument(): void
    {
        $typeDeclaration = new TypeDeclaration(null);
        $argument = new PhpArgument('argument', $typeDeclaration, 'null', false);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('$argument = null', $argumentFormatter->format());
    }

    /** @test */
    public function itCanFormatAReferenceArgument(): void
    {
        $typeDeclaration = new TypeDeclaration('string');
        $argument = new PhpArgument('argument', $typeDeclaration, "''", true);

        $argumentFormatter = new ArgumentFormatter($argument);

        $this->assertEquals('string &$argument = \'\'', $argumentFormatter->format());
    }
}
