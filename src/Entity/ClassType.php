<?php

namespace YeTii\PhpFile\Entity;

final class ClassType
{
    public const T_CLASS = 'class';
    public const T_INTERFACE = 'interface';
    public const T_TRAIT = 'trait';

    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        if (! in_array($value, [self::T_CLASS, self::T_INTERFACE, self::T_TRAIT], true)) {
            throw new \RuntimeException('Invalid class type specified');
        }

        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
