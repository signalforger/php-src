--TEST--
Array shape: optional keys with key?: type syntax
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

function getConfig(): array{host: string, port: int, ssl?: bool} {
    return [
        'host' => 'localhost',
        'port' => 3306
        // ssl is optional, not provided
    ];
}

function getConfigWithSsl(): array{host: string, port: int, ssl?: bool} {
    return [
        'host' => 'localhost',
        'port' => 3306,
        'ssl' => true
    ];
}

$config1 = getConfig();
echo "Host: {$config1['host']}, Port: {$config1['port']}\n";

$config2 = getConfigWithSsl();
echo "Host: {$config2['host']}, Port: {$config2['port']}, SSL: " . ($config2['ssl'] ? 'yes' : 'no') . "\n";

?>
--EXPECT--
Host: localhost, Port: 3306
Host: localhost, Port: 3306, SSL: yes
