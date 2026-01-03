--TEST--
Array shape: property assignment missing required key error
--XLEAK--
--FILE--
<?php


class Config {
    public array{host: string, port: int} $database;
}

$config = new Config();

// Valid assignment
$config->database = ['host' => 'localhost', 'port' => 3306];
echo "Valid assignment: OK\n";

// Invalid assignment - missing 'port'
try {
    $config->database = ['host' => 'localhost'];
} catch (TypeError $e) {
    echo "Missing key: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Valid assignment: OK
Missing key: Cannot assign to property Config::$database of type array{port: int, ...}, array given with missing key "port"
