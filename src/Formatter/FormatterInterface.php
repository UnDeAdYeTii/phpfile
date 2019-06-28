<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Formatter;

interface FormatterInterface
{
    public function format(): string;
}
