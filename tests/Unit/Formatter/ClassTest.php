<?php

namespace YeTii\PhpFile\Tests\Unit\Formatter;

use PHPUnit\Framework\TestCase;
use YeTii\PhpFile\Schemas\PhpClass;
use YeTii\PhpFile\Entities\ClassType;
use YeTii\PhpFile\Schemas\PhpMethod;
use YeTii\PhpFile\Entities\Visibility;
use YeTii\PhpFile\Schemas\PhpConstant;
use YeTii\PhpFile\Schemas\PhpProperty;
use YeTii\PhpFile\Formatters\ClassFormatter;

final class ClassTest extends TestCase
{
    /** @test */
    public function itCanFormatAValidEmptyClass(): void
    {
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, [], null, [], [], [], [], []
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    


class NewClass
{
    

    

    

    
}
PHP
            , $classFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidClassWithImports(): void
    {
        $imports = ['Tests\Ns\ClassOne', 'Tests\Ns\ClassTwo'];
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, $imports, null, [], [], [], [], []
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    
use Tests\Ns\ClassOne;
use Tests\Ns\ClassTwo;

class NewClass
{
    

    

    

    
}
PHP
            , $classFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidClassWithExtends(): void
    {
        $constants = [new PhpConstant('TEST_CONSTANT', new Visibility('public'), null)];
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, [], 'OldClass', [], [], [], [], $constants
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    


class NewClass extends OldClass
{
    

    public const TEST_CONSTANT = '';

    

    
}
PHP
            , $classFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidClassWithInterfaces(): void
    {
        $interfaces = ['Snappable'];
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, [], null, $interfaces, [], [], [], []
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    


class NewClass implements Snappable
{
    

    

    

    
}
PHP
            , $classFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidClassWithTraits(): void
    {
        $traits = ['Mind', 'Power', 'Reality', 'Soul', 'Space', 'Time'];
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, [], null, [], $traits, [], [], []
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    


class NewClass
{
    use Mind;
use Power;
use Reality;
use Soul;
use Space;
use Time;

    

    

    
}
PHP
            , $classFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidClassWithProperties(): void
    {
        $properties = [new PhpProperty('testProperty', new Visibility('private'), null)];
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, [], null, [], [], $properties, [], []
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    


class NewClass
{
    

    

    private $testProperty;

    
}
PHP
            , $classFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidClassWithMethods(): void
    {
        $methods = [new PhpMethod('testMethod', new Visibility('public'), null, [])];
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, [], null, [], null, [], $methods, []
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    


class NewClass
{
    

    

    

        public function testMethod() {
        
    }
}
PHP
            , $classFormatter->format());
    }

    /** @test */
    public function itCanFormatAValidClassWithConstants(): void
    {
        $constants = [new PhpConstant('TEST_CONSTANT', new Visibility('public'), null)];
        $classType = new ClassType(ClassType::T_CLASS);
        $class = new PhpClass(
            'NewClass', 'Tests\Ns', $classType, [], null, [], [], [], [], $constants
        );

        $classFormatter = new ClassFormatter($class);

        $this->assertEquals(<<<'PHP'
<?php

namespace Tests\Ns;
    


class NewClass
{
    

    public const TEST_CONSTANT = '';

    

    
}
PHP
            , $classFormatter->format());
    }
}
