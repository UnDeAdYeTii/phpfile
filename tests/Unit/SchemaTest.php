<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Tests\Unit;

use YeTii\PhpFile\Schematic;
use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Schema\PhpClass;
use YeTii\PhpFile\Exception\InvalidSchemaException;

final class SchemaTest extends TestCase
{
    /** @test */
    public function itThrowsAnExceptionOnNonExistantConfigurationFile(): void
    {
        $this->expectException(InvalidSchemaException::class);
        $this->expectExceptionMessage('Configuration schema file not found');

        Schematic::makeFromConfiguration(__DIR__.'/../schemas/non-existant-file.neon');
    }

    /** @test */
    public function itThrowsAnExceptionOnInvalidFileExtension(): void
    {
        $this->expectException(InvalidSchemaException::class);
        $this->expectExceptionMessage('Invalid configuration schema file extension');

        Schematic::makeFromConfiguration(__DIR__.'/../schemas/invalid.txt');
    }

    /** @test */
    public function itCreatesAPhpClassInstanceFromANeonSchemaFile(): void
    {
        $schema = Schematic::makeFromConfiguration(__DIR__.'/../schemas/valid.neon');

        $this->assertInstanceOf(PhpClass::class, $schema->getData());
    }

    /** @test */
    public function itCreatesAPhpClassInstanceFromAJsonSchemaFile(): void
    {
        $schema = Schematic::makeFromConfiguration(__DIR__.'/../schemas/valid.json');

        $this->assertInstanceOf(PhpClass::class, $schema->getData());
    }
}