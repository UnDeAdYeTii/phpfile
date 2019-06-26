<?php

namespace YeTii\Test;

use YeTii\Another\ClassOne;
use YeTii\Another\One as ClassTwo;

class file extends ExtendClass implements ImplementedClassOne, ImplementedClassTwo
{
    use ClassOne;
    use ClassTwo;

    protected $an_array = [];
    public $public_val = 'def';

    protected function functionName(int &$id, string $str = '', $extra = null)
    {
        // code
    }

    public function someName($arg)
    {
        // code
    }
}
