<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Entity;

final class TypeDeclaration
{
    /** @var string|null */
    private $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
