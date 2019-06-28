<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Formatter;

use YeTii\PhpFile\Schema\PhpProperty;

final class PropertyFormatter implements FormatterInterface
{
    /** @var PhpProperty */
    private $property;

    public function __construct(PhpProperty $property)
    {
        $this->property = $property;
    }

    public function format(): string
    {
        $defaultValue = $this->property->getDefault() ? ' = '.$this->property->getDefault() : '';
        $visibility = $this->property->getVisibility() ? $this->property->getVisibility().' ' : '';

        return "{$visibility}\${$this->property->getName()}{$defaultValue};";
    }
}
