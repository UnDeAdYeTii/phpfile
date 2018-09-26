<?php

namespace YeTii\PhpFile;

class File {

    protected $file;

    protected $lines = [];

    protected $line = '';

    protected $indent = 0;

    protected $spaces = 4;

    public function __construct($file) {
        $this->file = $file;
    }

    public function line() {
        foreach (func_get_args() as $arg) {
            if ($this->line !== '') {
                $this->lines[] = $this->pad().$this->line;
                $this->line = '';
            }
            $this->lines[] = $this->pad().$arg;
        }
        return $this;
    }

    public function break() {
        $this->lines[] = '';
        return $this;
    }

    public function string($arg, $submit = false) {
        $this->line .= $arg;
        if ($submit) {
            $this->lines[] = $this->pad().$this->line;
            $this->line = '';
        }
        return $this;
    }

    public function stringIf($arg, $if, $submit = false) {
        if ($if !== null && $if !== []) {
            $this->string($arg);
        }
        if ($submit) {
            $this->lines[] = $this->pad().$this->line;
            $this->line = '';
        }
        return $this;
    }

    public function compile() {
        return implode("\n", $this->lines);
    }

    public function lineIf($arg, $if) {
        if ($if !== null && $if !== []) {
            $this->line($arg);
        }
        return $this;
    }

    public function foreachIf($arg, $if) {
        if ($if !== null && $if !== []) {
            foreach ($arg as $a) {
                $this->line($a);
            }
        }
        return $this;
    }

    public function indent(int $indent) {
        $this->indent = abs($indent);
        return $this;
    }

    public function spaces(int $spaces) {
        $this->spaces = abs($spaces);
        return $this;
    }

    public function pad() {
        return str_pad('', $this->indent*$this->spaces, ' ', STR_PAD_LEFT);
    }

    public function write() {
        file_put_contents($this->file, $this->compile());
    }

}