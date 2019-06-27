<?php

namespace YeTii\PhpFile\Exception;

use RuntimeException;

final class InvalidSchemaException extends RuntimeException implements ExceptionInterface
{
    public static function configurationFileDoesNotExist(): self
    {
        return new self('Configuration schema file not found');
    }

    public static function invalidConfigurationFileExtension(): self
    {
        return new self('Invalid configuration schema file extension');
    }

    public static function invalidConfigurationFileContents(): self
    {
        return new self('Invalid configuration schema file contents');
    }
}
