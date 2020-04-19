# phpfile (DISCONTINUED - NO LONGER MAINTAINED)

This is a basic PHP File Generator library where you supply a schematic (json file or array) and it can produce a PHP files. 

## Customise

 * Namespaces
 * Uses
   * Aliases
 * Class
   * Types
   * Names
   * Extends
   * Implements
   * Uses
   * Properties
     * Visibility
     * Defaults
   * Methods
     * Visibility
     * Args
       * Typehints
       * Defaults
       * References

## Usage
```php
$schema = new \YeTii\PhpFile\Schematic();

$schema->read('schematic.json')->out('output.php');
// or
$data = [ /* schematic rules */ ];
$schema->read($data)->out('output.php');
```

## Features

 * Indenting + Indenting Control
 * More (fucking look yourself)
