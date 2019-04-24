<?php

namespace YeTii\PhpFile;

/**
 * Class Schematic
 */
class Schematic
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @param string $json
     * @return $this
     */
    public function read($json)
    {
        if (is_string($json) && \file_exists($json)) {
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

    /**
     * @param array $json
     * @return $this
     */
    public function fill($json)
    {
        $base = $this->schemaBase();
        $json = (array)$json;
        $orig = $json;
        $json = $json['class'];
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
            } elseif ($k == 'constants') {
                $constants = [];
                foreach ($v as $const) {
                    $constants[] = \array_merge($this->schemaConstant(), (array)$const);
                }
                $v = $constants;
            }
            $base[$k] = $v;
        }
        $this->data = $base;
        return $this;
    }

    /**
     * @return array
     */
    public function schemaBase()
    {
        return [
            "namespace"  => null,
            "type"       => null,
            "name"       => null,
            "uses"       => [],
            "implements" => [],
            "extends"    => null,
            "class_uses" => [],
            "properties" => [],
            "methods"    => [],
        ];
    }

    /**
     * @return array
     */
    public function schemaMethod()
    {
        return [
            "visibility" => null,
            "name"       => null,
            "code"       => null,
            "args"       => [],
        ];
    }

    /**
     * @return array
     */
    public function schemaProperty()
    {
        return [
            "visibility" => null,
            "name"       => null,
            "default"    => null,
        ];
    }

    /**
     * @return array
     */
    public function schemaConstant()
    {
        return [
            "visibility" => null,
            "name"       => null,
            "default"    => null,
        ];
    }

    /**
     * @return array
     */
    public function schemaArgument()
    {
        return [
            "typehint" => null,
            "name"     => null,
            "default"  => null,
            "ref"      => null,
        ];
    }

    /**
     * @param string $to
     * @return \YeTii\PhpFile\File
     */
    public function out($to)
    {
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
            $def = $prop['default'] ??
                function () {
                };
            $str = $v.' $'.$n.(is_callable($def) ? '' : ' = '.$def).';';
            $properties[] = $str;
        }

        $constants = [];
        foreach ($this->get('constants', []) as $const) {
            $v = $const['visibility'] ?? 'public';
            $n = $const['name'];
            $def = $const['default'];
            $str = $v . ' const ' . $n . ' = ' . $def . ";\n";
            $constants[] = $str;
        }
        
        $file->line('<?php', '')
            ->indent(0)
            ->lineIf('namespace '.$this->get('namespace').';', $this->get('namespace'))
            ->break()
            ->foreachIf(array_merge($uses, ['']), $uses)
            ->string("$type $name", 1)
            ->indent(1)
            ->lineIf("extends $extends", $extends)
            ->lineIf("implements $implements", $implements)
            ->indent(0)
            ->line('{')
            ->indent(1)
            ->break()
            ->foreachIf(array_merge($class_uses, ['']), $class_uses)
            ->foreachIf(array_merge($constants, ['']), $constants)
            ->foreachIf(array_merge($properties, ['']), $properties);
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
                ->lineIf(preg_replace('/\n/', "\n".$file->pad(), $code), $code)
                ->indent(1)
                ->line('}', '');
        }
        $file
            ->indent(0)
            ->line('}');
        return $file->write();
    }

    /**
     * @param string     $key
     * @param mixed|null $def
     * @return array|mixed|null
     */
    public function get($key, $def = null)
    {
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
