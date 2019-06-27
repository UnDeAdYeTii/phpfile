<?php

namespace YeTii\PhpFile;

use Nette\Neon\Neon;
use function json_decode;
use function file_get_contents;
use YeTii\PhpFile\Entity\TypeHint;
use YeTii\PhpFile\Schema\PhpClass;
use YeTii\PhpFile\Entity\ClassType;
use YeTii\PhpFile\Schema\PhpMethod;
use YeTii\PhpFile\Entity\Visibility;
use YeTii\PhpFile\Schema\PhpArgument;
use YeTii\PhpFile\Schema\PhpConstant;
use YeTii\PhpFile\Schema\PhpProperty;
use YeTii\PhpFile\Exception\InvalidSchemaException;

final class Schematic
{
    /** @var array */
    private $data;

    public function __construct(array $schema)
    {
        $classData = $schema['class'];
        $base = [];

        foreach ($classData as $key => $value) {
            if ($key === 'methods') {
                $value = $this->mapMethods($value);
            } elseif ($key === 'properties') {
                $value = $this->mapProperties($value);
            } elseif ($key === 'constants') {
                $value = $this->mapConstants($value);
            }

            $base[$key] = $value;
        }

        $this->data = new PhpClass(
            $schema['name'], $schema['namespace'], new ClassType($schema['type']),
            $schema['uses'], $schema['extends'], $schema['implements'], $schema['traits'],
            $base['properties'], $base['methods'], $base['constants']
        );
    }

    public static function makeFromConfiguration(string $configurationPath): self
    {
        if (! file_exists($configurationPath)) {
            throw InvalidSchemaException::configurationFileDoesNotExist();
        }

        $extension = substr($configurationPath, -4, 4);

        if (! in_array($extension, ['json', 'neon'])) {
            throw InvalidSchemaException::invalidConfigurationFileExtension();
        }

        if ($extension === 'neon') {
            $data = Neon::decode();

            return new self($data);
        }

        $json = file_get_contents($configurationPath);
        $data = json_decode($json, false);

        return new self($data);
    }

    public function getData(): ?PhpClass
    {
        return $this->data;
    }

    private function mapConstants(array $value): array
    {
        return array_map(static function (array $constant) {
            return new PhpConstant(
                $constant['name'],
                new Visibility($constant['visibility']),
                $constant['default'] ?? null
            );
        }, $value);
    }

    private function mapProperties(array $value): array
    {
        return array_map(static function (array $property) {
            return new PhpProperty(
                $property['name'],
                new Visibility($property['visibility']),
                $property['default'] ?? null
            );
        }, $value);
    }

    private function mapMethods(array $value): array
    {
        return array_map(static function (array $method) {
            $arguments = array_map(static function (array $argument) {
                return new PhpArgument(
                    $argument['name'],
                    new TypeHint($argument['typehint']),
                    $argument['default'],
                    (bool) $argument['reference']
                );
            }, $method['arguments']);

            return new PhpMethod(
                $method['name'],
                new Visibility($method['visibility']),
                $method['code'] ?? null,
                $arguments ?? null
            );
        }, $value);
    }
}
