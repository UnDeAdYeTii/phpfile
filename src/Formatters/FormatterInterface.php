<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Formatters;

interface FormatterInterface
{
    public function format(): string;
}
