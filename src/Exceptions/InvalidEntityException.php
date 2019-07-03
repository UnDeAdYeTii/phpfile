<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Exceptions;

use RuntimeException;

final class InvalidEntityException extends RuntimeException implements ExceptionInterface
{
    public static function invalidClassTypeSpecified(): self
    {
        return new self('Invalid class type specified');
    }

    public static function invalidVisibilitySpecified(): self
    {
        return new self('Invalid visibility specified');
    }
}
