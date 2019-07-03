<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Tests\Unit;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Entities\ClassType;
use YeTii\PhpFile\Entities\Visibility;
use YeTii\PhpFile\Exceptions\InvalidEntityException;

final class InvalidEntityTest extends TestCase
{
    /** @test */
    public function itThrowsAnExceptionOnInvalidClassType(): void
    {
        $this->expectException(InvalidEntityException::class);
        $this->expectExceptionMessage('Invalid class type specified');

        new ClassType('Invalid class type');
    }

    /** @test */
    public function itThrowsAnExceptionOnInvalidVisibility(): void
    {
        $this->expectException(InvalidEntityException::class);
        $this->expectExceptionMessage('Invalid visibility specified');

        new Visibility('Invalid visibility');
    }
}
