<?php

namespace YeTii\PhpFile\Tests;

use RuntimeException;
use YeTii\PhpFile\Schematic;
use PHPUnit\Framework\TestCase;

final class SchemaTest extends TestCase
{
    /** @test */
    public function itThrowsAnExceptionOnNonExistantConfigurationFile(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Configuration schema file not found');

        Schematic::makeFromConfiguration(__DIR__.'/schemas/non-existant-file.neon');
    }

    /** @test */
    public function itThrowsAnExceptionOnInvalidFileExtension(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Invalid configuration schema file extension');

        Schematic::makeFromConfiguration(__DIR__.'/schemas/invalid.txt');
    }
}
