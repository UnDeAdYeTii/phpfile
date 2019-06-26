<?php

namespace YeTii\PhpFile;

use RuntimeException;
use function json_decode;
use function file_get_contents;

final class Schematic
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function makeFromConfiguration(string $configurationPath): self
    {
        if (! file_exists($configurationPath)) {
            throw new RuntimeException('Configuration file not found');
        }

        $json = file_get_contents($configurationPath);
        $data = json_decode($json, false);

        return new self($data);
    }

    public function getData(): array
    {
        return $this->data;
    }
}
