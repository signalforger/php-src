--TEST--
Array shape: property assignment validation
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

class Config {
    public array{host: string, port: int} $database;

    public function __construct() {
        $this->database = ['host' => 'localhost', 'port' => 3306];
    }
}

$config = new Config();
echo "Host: {$config->database['host']}\n";
echo "Port: {$config->database['port']}\n";

// Update with valid data
$config->database = ['host' => '127.0.0.1', 'port' => 5432];
echo "Updated host: {$config->database['host']}\n";
echo "Updated port: {$config->database['port']}\n";

?>
--EXPECT--
Host: localhost
Port: 3306
Updated host: 127.0.0.1
Updated port: 5432
