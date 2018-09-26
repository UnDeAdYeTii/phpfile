<?php

namespace YeTii\PhpFile;

use YeTii\PhpFile\File;

class Schematic {

    public $data = [];

    public function read($json) {
        if (\file_exists($json)) {
            $json = \file_get_contents($json);
        }
        if (is_string($json)) {
            $json = \json_decode($json);
        }
        if (!$json) {
            return $this;
        }
        $this->fill($json);
        return $this;
    }

    public function fill($json) {
        $base = $this->schemaBase();

        $orig = $json;
        $json = $json->class;

        foreach ($json as $k => $v) {
            if ($k == 'methods') {
                $methods = [];
                foreach ($v as $method) {
                    $methodBase = $this->schemaMethod();
                    foreach ($method as $k2 => $v2) {
                        if ($k2 == 'args') {
                            $args = [];
                            foreach ($v2 as $arg) {
                                $args[] = \array_merge($this->schemaArgument(), (array)$arg);
                            }
                            $v2 = $args;
                        }
                        $methodBase[$k2] = $v2;
                    }
                    $methods[] = $methodBase;
                }
                $v = $methods;
            } elseif ($k == 'properties') {
                $properties = [];
                foreach ($v as $props) {
                    $properties[] = \array_merge($this->schemaProperty(), (array)$props);
                }
                $v = $properties;
            }
            $base[$k] = $v;
        }
        $this->data = $base;
        return $this;
    }

    public function schemaBase() {
        return [
            "namespace" => null,
            "type" => null,
            "name" => null,
            "uses" => [],
            "implements" => [],
            "extends" => null,
            "class_uses" => [],
            "properties" => [],
            "methods" => []
        ];
    }

    public function schemaMethod() {
        return [
            "visibility" => null,
            "name" => null,
            "code" => null,
            "args" => []
        ];
    }

    public function schemaProperty() {
        return [
            "visibility" => null,
            "name" => null,
            "default" => null,
        ];
    }

    public function schemaArgument() {
        return [
            "typehint" => null,
            "name" => null,
            "default" => null,
            "ref" => null,
        ];
    }
 
    public function out($to) {
        $file = new File($to);

        $uses = [];
        foreach ($this->get('uses', []) as $use) {
            if (is_string($use)) {
                $uses[] = 'use '.$use.';';
            } else {
                $b = array_keys((array)$use);
                $b = array_reverse($b);
                $b = array_pop($b);

                $a = array_values((array)$use);
                $a = array_pop($a);

                $u = 'use '.$b.' as '.$a.';';
                $uses[] = $u;
            }
        }
        $type = $this->get('type');
        $name = $this->get('name');
        $extends = $this->get('extends');
        $implements = implode(', ', $this->get('implements', []));
        $class_uses = [];
        foreach ($this->get('class_uses', []) as $use) {
            if (is_string($use)) {
                $class_uses[] = 'use '.$use.';';
            } else {
                $b = array_keys((array)$use);
                $b = array_reverse($b);
                $b = array_pop($b);

                $a = array_values((array)$use);
                $a = array_pop($a);

                $u = 'use '.$b.' as '.$a.';';
                $class_uses[] = $u;
            }
        }

        $properties = [];
        foreach ($this->get('properties', []) as $prop) {
            $v = $prop['visibility'] ?? 'public';
            $n = $prop['name'];
            $def = $prop['default'] ?? function() {};
            $str = $v.' $'.$n.(is_callable($def)?'':' = '.$def).';';
            $properties[] = $str;
        }

        $file->line('<?php', '')
            ->indent(0)
            ->lineIf('namespace '.$this->get('namespace').';', $this->get('namespace'))
            ->break()
            ->foreachIf(array_merge($uses, ['']), count($uses))
            ->string("$type $name", 1)
            ->indent(1)
                ->lineIf("extends $extends", $extends)
                ->lineIf("implements $implements", $implements)
            ->indent(0)
            ->line('{')
            ->break()
            ->indent(1)
                ->foreachIf(array_merge($class_uses, ['']), count($class_uses))
                ->foreachIf(array_merge($properties, ['']), count($properties));

        foreach ($this->get('methods', []) as $method) {
            $v = $method['visibility'];
            $n = $method['name'];
            $methods = $method['args'] ?? [];

            $args = [];
            foreach ($methods as $arg) {
                $at = $arg['typehint'] ? $arg['typehint'].' ' : '';
                $an = '$'.$arg['name'];
                $ad = $arg['default'] ? ' = '.$arg['default'] : '';
                $an = $arg['ref'] ? '&'.$an : $an;
                $str = $at.$an.$ad;
                $args[] = $str;
            }
            $args = implode(', ', $args);

            $code = $method['code'] ?? '// code';
            $str = "$v function $n($args)";
            $file->line($str)
                ->line('{')
                ->indent(2)
                    ->lineIf($code, $code)
                ->indent(1)
                ->line('}', '');
        }

        $file
            ->indent(0)
            ->line('}');

        $file->write();
    }

    public function get($key, $def = null) {
        $data = $this->data;
        foreach (explode('.', $key) as $k) {
            if (!is_array($data) || !isset($data[$k])) {
                return $def;
            }
            $data = &$data[$k];
        }
        return $data;
    }

}