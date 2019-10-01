<?php

declare(strict_types=1);

namespace YeTii\PhpFile\Formatters;

use YeTii\PhpFile\Schemas\PhpMethod;
use YeTii\PhpFile\Schemas\PhpArgument;

final class MethodFormatter implements FormatterInterface
{
    /** @var PhpMethod */
    private $method;

    public function __construct(PhpMethod $method)
    {
        $this->method = $method;
    }

    public function format(): string
    {
        $arguments = array_map(static function (PhpArgument $argument) {
            return (new ArgumentFormatter($argument))->format();
        }, $this->method->getArguments());

        $methodArguments = implode(',', $arguments);

        return <<<PHP
    {$this->method->getVisibility()} function {$this->method->getName()}({$methodArguments}) {
        {$this->method->getCode()}
    }
PHP;
    }
}
