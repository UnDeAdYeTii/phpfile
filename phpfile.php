<?php

require 'vendor/autoload.php';

$schema = new \YeTii\PhpFile\Schematic();
$schema->read('php.json')->out('file.php');
