<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Schema;

use YeTii\PhpFile\Entity\Visibility;

/** @internal */
final class PhpConstant
{
    /** @var Visibility */
    private $visibility;
    /** @var string */
    private $name;
    /** @var mixed|null */
    private $default;

    public function __construct(string $name, Visibility $visibility, $default)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->default = $default;
    }
}
