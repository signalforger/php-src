--TEST--
Array shape: function return type error (shapes work for function returns)
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

function getConfig(): array{host: string, port: int} {
    return ['host' => 'localhost']; // Missing 'port'
}

try {
    getConfig();
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Caught: getConfig(): Return value must be of type array{port: int, ...}, array given with missing key "port"
