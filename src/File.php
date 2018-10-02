<?php

namespace YeTii\PhpFile;

/**
 * Class File
 */
class File
{
    /**
     * @var string
     */
    protected $compiled;
    /**
     * @var string
     */
    protected $file;
    /**
     * @var array
     */
    protected $lines = [];
    /**
     * @var string
     */
    protected $line = '';
    /**
     * @var int
     */
    protected $indent = 0;
    /**
     * @var int
     */
    protected $spaces = 4;

    /**
     * File constructor.
     * @param $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * @return $this
     */
    public function line()
    {
        foreach (func_get_args() as $arg) {
            if ($this->line !== '') {
                $this->lines[] = $this->pad().$this->line;
                $this->line = '';
            }
            $this->lines[] = $this->pad().$arg;
        }
        return $this;
    }

    /**
     * @return $this
     */
    public function break()
    {
        $this->lines[] = '';
        return $this;
    }

    /**
     * @param string $arg
     * @param bool   $submit
     * @return $this
     */
    public function string($arg, $submit = false)
    {
        $this->line .= $arg;
        if ($submit) {
            $this->lines[] = $this->pad().$this->line;
            $this->line = '';
        }
        return $this;
    }

    /**
     * @param string       $arg
     * @param mixed|string $if
     * @param bool         $submit
     * @return $this
     */
    public function stringIf($arg, $if, $submit = false)
    {
        if ($if !== null && $if !== [] && $if !== '') {
            $this->string($arg);
        }
        if ($submit) {
            $this->lines[] = $this->pad().$this->line;
            $this->line = '';
        }
        return $this;
    }

    /**
     * @return string
     */
    public function compile()
    {
        return implode("\n", $this->lines);
    }

    /**
     * @param string       $arg
     * @param mixed|string $if
     * @return $this
     */
    public function lineIf($arg, $if)
    {
        if ($if !== null && $if !== [] && $if !== '') {
            $this->line($arg);
        }
        return $this;
    }

    /**
     * @param array|string|mixed $arg
     * @param mixed|string       $if
     * @return $this
     */
    public function foreachIf($arg, $if)
    {
        if ($if !== null && $if !== [] && $if !== '') {
            foreach ($arg as $a) {
                $this->line($a);
            }
        }
        return $this;
    }

    /**
     * @param int $indent
     * @return $this
     */
    public function indent(int $indent)
    {
        $this->indent = abs($indent);
        return $this;
    }

    /**
     * @param int $spaces
     * @return $this
     */
    public function spaces(int $spaces)
    {
        $this->spaces = abs($spaces);
        return $this;
    }

    /**
     * @return string
     */
    public function pad()
    {
        return str_pad('', $this->indent * $this->spaces, ' ', STR_PAD_LEFT);
    }

    /**
     * @return $this
     */
    public function write()
    {
        $this->compiled = $this->compile();
        file_put_contents($this->file, $this->compiled);
        return $this;
    }
}
