<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Formatter;

use YeTii\PhpFile\Schema\PhpArgument;

final class ArgumentFormatter implements FormatterInterface
{
    /** @var PhpArgument */
    private $argument;

    public function __construct(PhpArgument $argument)
    {
        $this->argument = $argument;
    }

    public function format(): string
    {
        $defaultValue = $this->argument->getDefault() ? ' = '.$this->argument->getDefault() : '';
        $reference = $this->argument->isReference() ? '&' : '';

        return "{$this->argument->getTypehint()} {$reference}{$this->argument->getName()} {$defaultValue}";
    }
}
