<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Schema;

use YeTii\PhpFile\Entity\Visibility;

/** @internal */
final class PhpMethod
{
    /** @var Visibility */
    private $visibility;
    /** @var string */
    private $name;
    /** @var string|null */
    private $code;
    /** @var array<PhpArgument>|null */
    private $arguments;

    /**
     * @param  string  $name
     * @param  Visibility  $visibility
     * @param  string|null  $code
     * @param  array<PhpArgument>|null  $arguments
     */
    public function __construct(string $name, Visibility $visibility, ?string $code, ?array $arguments)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->code = $code;
        $this->arguments = $arguments;
    }

    public function getVisibility(): string
    {
        return $this->visibility->getValue();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    /** @return array<PhpArgument> */
    public function getArguments(): array
    {
        return $this->arguments ?? [];
    }
}
