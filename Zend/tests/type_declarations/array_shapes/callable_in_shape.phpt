--TEST--
Callable type in array shapes
--XLEAK--
--FILE--
<?php

// Test 1: Basic callable in shape
function processWithCallback(array{data: array<int>, callback: callable} $config): array<int> {
    return array_map($config['callback'], $config['data']);
}

$result = processWithCallback([
    'data' => [1, 2, 3],
    'callback' => fn($x) => $x * 2
]);
echo "Doubled: ";
print_r($result);

// Test 2: Callable as closure
function executeHandler(array{name: string, handler: callable} $action): string {
    return $action['handler']($action['name']);
}

$greeting = executeHandler([
    'name' => 'World',
    'handler' => fn($name) => "Hello, $name!"
]);
echo "$greeting\n";

// Test 3: Callable as function name
function myUppercase(string $s): string {
    return strtoupper($s);
}

$result = executeHandler([
    'name' => 'test',
    'handler' => 'myUppercase'
]);
echo "$result\n";

// Test 4: Callable as static method reference
class StringUtils {
    public static function reverse(string $s): string {
        return strrev($s);
    }
}

$result = executeHandler([
    'name' => 'hello',
    'handler' => [StringUtils::class, 'reverse']
]);
echo "$result\n";

// Test 5: Optional callable
function maybeProcess(array{value: int, transformer?: callable} $data): int {
    if (isset($data['transformer'])) {
        return $data['transformer']($data['value']);
    }
    return $data['value'];
}

echo "Without transformer: " . maybeProcess(['value' => 5]) . "\n";
echo "With transformer: " . maybeProcess(['value' => 5, 'transformer' => fn($x) => $x * 10]) . "\n";

echo "Done\n";
?>
--EXPECT--
Doubled: Array
(
    [0] => 2
    [1] => 4
    [2] => 6
)
Hello, World!
TEST
olleh
Without transformer: 5
With transformer: 50
Done
