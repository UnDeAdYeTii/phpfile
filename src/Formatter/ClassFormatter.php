<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Formatter;

use YeTii\PhpFile\Schema\PhpClass;
use YeTii\PhpFile\Schema\PhpMethod;
use YeTii\PhpFile\Schema\PhpProperty;
use YeTii\PhpFile\Schema\PhpConstant;

final class ClassFormatter implements FormatterInterface
{
    /** @var PhpClass */
    private $class;

    public function __construct(PhpClass $class)
    {
        $this->class = $class;
    }

    public function format(): string
    {
        $namespace = $this->class->getNamespace() ? "namespace {$this->class->getNamespace()};" : '';
        $extends = $this->class->getExtends() ? " extends {$this->class->getExtends()}" : '';

        $uses = $this->buildUses($this->class->getUses());
        $implements = $this->buildImplements($this->class->getImplements());
        $traits = $this->buildTraits($this->class->getTraits());
        $constants = $this->buildConstants($this->class->getConstants());
        $properties = $this->buildProperties($this->class->getProperties());
        $methods = $this->buildMethods($this->class->getMethods());

        return <<<PHP
<?php

{$namespace}
    
{$uses}

{$this->class->getType()} {$this->class->getName()}{$extends}{$implements}
{
    {$traits}

    {$constants}

    {$properties}

    {$methods}
}
PHP;
    }

    /**
     * @param  array<string>  $implements
     *
     * @return string
     */
    private function buildImplements(array $implements): string
    {
        if (count($implements) === 0) {
            return '';
        }

        $list = implode(', ', $implements);

        return " implements {$list}";
    }

    /**
     * @param  array<string>  $traits
     *
     * @return string
     */
    private function buildTraits(array $traits): string
    {
        $list = array_map(static function (string $trait) {
            return "use {$trait};";
        }, $traits);

        return implode("\n", $list);
    }

    /**
     * @param  array<PhpConstant>  $constants
     *
     * @return string
     */
    private function buildConstants(array $constants): string
    {
        $list = array_map(static function (PhpConstant $constant) {
            return (new ConstantFormatter($constant))->format();
        }, $constants);

        return implode("\n", $list);
    }

    /**
     * @param  array<PhpProperty>  $properties
     *
     * @return string
     */
    private function buildProperties(array $properties): string
    {
        $list = array_map(static function (PhpProperty $property) {
            return (new PropertyFormatter($property))->format();
        }, $properties);

        return implode("\n", $list);
    }

    /**
     * @param  array<PhpMethod>  $methods
     *
     * @return string
     */
    private function buildMethods(array $methods): string
    {
        $list = array_map(static function (PhpMethod $method) {
            return (new MethodFormatter($method))->format();
        }, $methods);

        return implode("\n\n", $list);
    }

    /**
     * @param  array<string>  $uses
     *
     * @return string
     */
    private function buildUses(array $uses): string
    {
        $list = array_map(static function (string $use) {
            return "use {$use};";
        }, $uses);

        return implode("\n", $list);
    }
}
