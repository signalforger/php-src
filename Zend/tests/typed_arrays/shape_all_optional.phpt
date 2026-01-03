--TEST--
Array shape: all optional keys allows empty array
--XLEAK--
--FILE--
<?php


function getConfig(): array{timeout?: int, retries?: int, debug?: bool} {
    return [];
}

function getPartialConfig(): array{timeout?: int, retries?: int, debug?: bool} {
    return ['timeout' => 30];
}

$empty = getConfig();
$partial = getPartialConfig();

echo "Empty config: " . count($empty) . " keys\n";
echo "Partial config timeout: " . ($partial['timeout'] ?? 'not set') . "\n";

?>
--EXPECT--
Empty config: 0 keys
Partial config timeout: 30
