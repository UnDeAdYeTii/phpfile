# phpfile

This is a basic PHP File Generator library where you supply a schematic (json file or array) and it can produce PHP files.

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
use YeTii\PhpFile\Schematic;

// Create from either a JSON or Neon configuration file
$schematic = Schematic::makeFromConfiguration('schematic.neon');

// Or create from a PHP array of schematic rules
$data = [ /* schematic rules */ ];
$schematic = new Schematic($data);

// Retrieve the PhpClass instance from a schematic
$schematic->getData();

// Retrieve the PhpClass instance as a string
(new ClassFormatter($schematic->getData()))->format();
```
