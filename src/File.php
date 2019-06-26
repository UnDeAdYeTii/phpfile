<?php

namespace YeTii\PhpFile;

final class File
{
    /** @var string */
    protected $compiled;
    /** @var string */
    protected $file;
    /** @var array */
    protected $lines = [];
    /** @var string */
    protected $line = '';
    /** @var int */
    protected $indent = 0;
    /** @var int */
    protected $spaces = 4;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function line(): self
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

    public function break(): self
    {
        $this->lines[] = '';
        return $this;
    }

    public function string(string $arg, bool $submit = false): self
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
    public function stringIf(string $arg, $if, bool $submit = false): self
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

    public function compile(): string
    {
        return implode("\n", $this->lines);
    }

    /**
     * @param string       $arg
     * @param mixed|string $if
     * @return $this
     */
    public function lineIf(string $arg, $if): self
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
    public function foreachIf($arg, $if): self
    {
        if ($if !== null && $if !== [] && $if !== '') {
            foreach ($arg as $a) {
                $this->line($a);
            }
        }
        return $this;
    }

    public function indent(int $indent): self
    {
        $this->indent = abs($indent);
        return $this;
    }

    public function spaces(int $spaces): self
    {
        $this->spaces = abs($spaces);
        return $this;
    }

    public function pad(): string
    {
        return str_pad('', $this->indent * $this->spaces, ' ', STR_PAD_LEFT);
    }

    public function write(): self
    {
        $this->compiled = $this->compile();
        file_put_contents($this->file, $this->compiled);
        return $this;
    }
}
