<?php

namespace YeTii\PhpFile\Tests\Unit\Formatter;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Entities\Visibility;
use YeTii\PhpFile\Schemas\PhpProperty;
use YeTii\PhpFile\Formatters\PropertyFormatter;

final class PropertyTest extends TestCase
{
    /** @test */
    public function itCanFormatAValidEmptyProperty(): void
    {
        $visibility = new Visibility('public');
        $constant = new PhpProperty('property', $visibility, null);

        $propertyFormatter = new PropertyFormatter($constant);

        $this->assertEquals('public $property;', $propertyFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidStringConstant(): void
    {
        $visibility = new Visibility('public');
        $constant = new PhpProperty('property', $visibility, '\'\'');

        $propertyFormatter = new PropertyFormatter($constant);

        $this->assertEquals('public $property = \'\';', $propertyFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidArrayConstant(): void
    {
        $visibility = new Visibility('public');
        $constant = new PhpProperty('property', $visibility, '[]');

        $propertyFormatter = new PropertyFormatter($constant);

        $this->assertEquals('public $property = [];', $propertyFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidProtectedConstant(): void
    {
        $visibility = new Visibility('protected');
        $constant = new PhpProperty('property', $visibility, null);

        $propertyFormatter = new PropertyFormatter($constant);

        $this->assertEquals('protected $property;', $propertyFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidPrivateConstant(): void
    {
        $visibility = new Visibility('private');
        $constant = new PhpProperty('property', $visibility, null);

        $propertyFormatter = new PropertyFormatter($constant);

        $this->assertEquals('private $property;', $propertyFormatter->format());
    }
}
