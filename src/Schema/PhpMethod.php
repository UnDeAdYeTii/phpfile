<?php

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

    public function __construct(string $name, Visibility $visibility, ?string $code, ?array $arguments)
    {
        $this->name = $name;
        $this->visibility = $visibility;
        $this->code = $code;
        $this->arguments = $arguments;
    }
}
