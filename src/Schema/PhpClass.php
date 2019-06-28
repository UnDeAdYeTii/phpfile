<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Schema;

use YeTii\PhpFile\Entity\ClassType;

/** @internal */
final class PhpClass
{
    /** @var string|null */
    private $namespace;
    /** @var ClassType */
    private $type;
    /** @var string */
    private $name;
    /** @var array<string|array<string,string>> */
    private $uses;
    /** @var array<string> */
    private $implements;
    /** @var string|null */
    private $extends;
    /** @var array<string> */
    private $traits;
    /** @var array<PhpProperty> */
    private $properties;
    /** @var array<PhpMethod> */
    private $methods;
    /** @var array<PhpConstant> */
    private $constants;

    /**
     * @param  string  $name
     * @param  string|null  $namespace
     * @param  ClassType  $type
     * @param  array<string>  $uses
     * @param  string|null  $extends
     * @param  array<string>  $implements
     * @param  array<string>|null  $traits
     * @param  array<PhpProperty>  $properties
     * @param  array<PhpMethod>  $methods
     * @param  array<PhpConstant>  $constants
     */
    public function __construct(
        string $name,
        ?string $namespace,
        ClassType $type,
        array $uses,
        ?string $extends,
        array $implements,
        ?array $traits,
        array $properties,
        array $methods,
        array $constants
    ) {
        $this->namespace = $namespace;
        $this->type = $type;
        $this->name = $name;
        $this->uses = $uses;
        $this->implements = $implements;
        $this->extends = $extends;
        $this->traits = $traits ?? [];
        $this->properties = $properties;
        $this->methods = $methods;
        $this->constants = $constants;
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function getType(): ClassType
    {
        return $this->type->getValue();
    }

    public function getName(): string
    {
        return $this->name;
    }

    /** @return array<string|array<string,string>> */
    public function getUses(): array
    {
        return $this->uses;
    }

    /** @return array<string> */
    public function getImplements(): array
    {
        return $this->implements;
    }

    public function getExtends(): ?string
    {
        return $this->extends;
    }

    /** @return array<string> */
    public function getTraits(): array
    {
        return $this->traits;
    }

    /** @return array<PhpProperty> */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /** @return array<PhpMethod> */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /** @return array<PhpConstant> */
    public function getConstants(): array
    {
        return $this->constants;
    }
}
