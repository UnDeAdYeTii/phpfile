<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Schema;

use YeTii\PhpFile\Entity\TypeDeclaration;

/** @internal */
final class PhpArgument
{
    /** @var string|null */
    private $default;
    /** @var string */
    private $name;
    /** @var bool */
    private $reference;
    /** @var TypeDeclaration */
    private $typeDeclaration;

    public function __construct(string $name, TypeDeclaration $typeDeclaration, ?string $default, bool $reference)
    {
        $this->name = $name;
        $this->typeDeclaration = $typeDeclaration;
        $this->default = $default;
        $this->reference = $reference;
    }

    public function getDefault(): ?string
    {
        return $this->default;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isReference(): bool
    {
        return $this->reference;
    }

    public function getTypeDeclaration(): ?string
    {
        return $this->typeDeclaration->getValue();
    }
}
