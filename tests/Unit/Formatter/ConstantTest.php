<?php

namespace YeTii\PhpFile\Tests\Unit\Formatter;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Entity\Visibility;
use YeTii\PhpFile\Schema\PhpConstant;
use YeTii\PhpFile\Formatter\ConstantFormatter;

final class ConstantTest extends TestCase
{
    /** @test */
    public function itCanFormatAValidEmptyConstant(): void
    {
        $visibility = new Visibility('public');
        $constant = new PhpConstant('TEST_CONSTANT', $visibility, null);

        $constantFormatter = new ConstantFormatter($constant);

        $this->assertEquals('public const TEST_CONSTANT = \'\';', $constantFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidStringConstant(): void
    {
        $visibility = new Visibility('public');
        $constant = new PhpConstant('TEST_CONSTANT', $visibility, '\'\'');

        $constantFormatter = new ConstantFormatter($constant);

        $this->assertEquals('public const TEST_CONSTANT = \'\';', $constantFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidArrayConstant(): void
    {
        $visibility = new Visibility('public');
        $constant = new PhpConstant('TEST_CONSTANT', $visibility, '[]');

        $constantFormatter = new ConstantFormatter($constant);

        $this->assertEquals('public const TEST_CONSTANT = [];', $constantFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidProtectedConstant(): void
    {
        $visibility = new Visibility('protected');
        $constant = new PhpConstant('TEST_CONSTANT', $visibility, '[]');

        $constantFormatter = new ConstantFormatter($constant);

        $this->assertEquals('protected const TEST_CONSTANT = [];', $constantFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidPrivateConstant(): void
    {
        $visibility = new Visibility('private');
        $constant = new PhpConstant('TEST_CONSTANT', $visibility, '[]');

        $constantFormatter = new ConstantFormatter($constant);

        $this->assertEquals('private const TEST_CONSTANT = [];', $constantFormatter->format());
    }
}
