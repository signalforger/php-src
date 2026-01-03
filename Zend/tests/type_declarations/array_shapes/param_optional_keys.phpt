--TEST--
Array shape as parameter type - optional keys
--XLEAK--
--FILE--
<?php

function processConfig(array{host: string, port?: int, ssl?: bool} $config): string {
    $result = $config['host'];
    if (isset($config['port'])) {
        $result .= ':' . $config['port'];
    }
    if (isset($config['ssl']) && $config['ssl']) {
        $result = 'https://' . $result;
    } else {
        $result = 'http://' . $result;
    }
    return $result;
}

// Only required key
echo processConfig(['host' => 'localhost']) . "\n";

// With optional port
echo processConfig(['host' => 'example.com', 'port' => 8080]) . "\n";

// With all keys
echo processConfig(['host' => 'secure.com', 'port' => 443, 'ssl' => true]) . "\n";

?>
--EXPECT--
http://localhost
http://example.com:8080
https://secure.com:443
