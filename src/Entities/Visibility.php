<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Entities;

use YeTii\PhpFile\Exceptions\InvalidEntityException;

final class Visibility
{
    public const PRIVATE = 'private';
    public const PROTECTED = 'protected';
    public const PUBLIC = 'public';

    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        if (! in_array($value, [self::PRIVATE, self::PROTECTED, self::PUBLIC], true)) {
            throw InvalidEntityException::invalidVisibilitySpecified();
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
