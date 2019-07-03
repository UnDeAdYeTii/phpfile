<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Entities;

final class TypeDeclaration
{
    /** @var string|null */
    private $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }
}
