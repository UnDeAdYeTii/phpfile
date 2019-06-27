<?php

namespace YeTii\PhpFile\Schema;

use YeTii\PhpFile\Entity\Visibility;

/** @internal */
final class PhpProperty
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
}
