<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Schemas;

use YeTii\PhpFile\Entities\Visibility;

/** @internal */
final class PhpConstant
{
    /** @var Visibility */
    private $visibility;
    /** @var string */
    private $name;
    /** @var string|null */
    private $default;

    public function __construct(string $name, Visibility $visibility, ?string $default)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->default = $default;
    }

    public function getVisibility(): string
    {
        return $this->visibility->getValue();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault(): string
    {
        return $this->default ?? "''";
    }
}
