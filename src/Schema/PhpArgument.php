<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Schema;

use YeTii\PhpFile\Entity\TypeHint;

/** @internal */
final class PhpArgument
{
    /** @var string|null */
    private $default;
    /** @var string */
    private $name;
    /** @var bool */
    private $reference;
    /** @var TypeHint */
    private $typehint;

    public function __construct(string $name, TypeHint $typehint, ?string $default, bool $reference)
    {
        $this->name = $name;
        $this->typehint = $typehint;
        $this->default = $default;
        $this->reference = $reference;
    }
}
