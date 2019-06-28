<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Formatter;

use YeTii\PhpFile\Schema\PhpConstant;

final class ConstantFormatter implements FormatterInterface
{
    /** @var PhpConstant */
    private $constant;

    public function __construct(PhpConstant $constant)
    {
        $this->constant = $constant;
    }

    public function format(): string
    {
        return "{$this->constant->getVisibility()} const {$this->constant->getName()} = {$this->constant->getDefault()}";
    }
}
