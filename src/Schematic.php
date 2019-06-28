<?php

declare(strict_types=1);

namespace YeTii\PhpFile;

use Nette\Neon\Neon;
use function json_decode;
use function file_get_contents;
use YeTii\PhpFile\Entity\TypeDeclaration;
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
    /** @var PhpClass */
    private $data;

    /** @param  array<mixed>  $schema */
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
            $classData['name'], $classData['namespace'], new ClassType($classData['type']),
            $classData['uses'], $classData['extends'], $classData['implements'], $classData['traits'],
            $base['properties'] ?? [], $base['methods'] ?? [], $base['constants'] ?? []
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

        $configurationContents = (string) file_get_contents($configurationPath);

        $data = $extension === 'neon' ?
            Neon::decode($configurationContents) :
            json_decode($configurationContents, true);

        return new self($data);
    }

    public function getData(): ?PhpClass
    {
        return $this->data;
    }

    /**
     * @param  array<array<array|bool|string|null>>  $value
     *
     * @return array<PhpConstant>
     */
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

    /**
     * @param  array<array<array|bool|string|null>>  $value
     *
     * @return array<PhpProperty>
     */
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

    /**
     * @param  array<array<array|bool|string|null>>  $value
     *
     * @return array<PhpMethod>
     */
    private function mapMethods(array $value): array
    {
        return array_map(static function (array $method) {
            $arguments = array_map(static function (array $argument) {
                return new PhpArgument(
                    $argument['name'],
                    new TypeDeclaration($argument['typehint'] ?? null),
                    $argument['default'] ?? null,
                    (bool) ($argument['reference'] ?? null)
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
