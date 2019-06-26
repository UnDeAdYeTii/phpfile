<?php

namespace YeTii\PhpFile\Entity;

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
            throw new \RuntimeException('Invalid visibility specified');
        }

        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
