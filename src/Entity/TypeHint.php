<?php

namespace YeTii\PhpFile\Entity;

final class TypeHint
{
    /** @var string */
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
