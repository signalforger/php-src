--TEST--
Closure type in array shapes
--XLEAK--
--FILE--
<?php

// Test 1: Closure type in shape (more specific than callable)
function processWithClosure(array{handler: Closure} $config): mixed {
    return $config['handler']();
}

$result = processWithClosure([
    'handler' => fn() => 'Hello from closure'
]);
echo "$result\n";

// Test 2: Closure with use()
$multiplier = 3;
$result = processWithClosure([
    'handler' => function() use ($multiplier) {
        return 10 * $multiplier;
    }
]);
echo "Result: $result\n";

// Test 3: Array of closures
function runAll(array{tasks: array<Closure>} $config): array<mixed> {
    $results = [];
    foreach ($config['tasks'] as $task) {
        $results[] = $task();
    }
    return $results;
}

$results = runAll([
    'tasks' => [
        fn() => 1,
        fn() => 2,
        fn() => 3,
    ]
]);
echo "Tasks results: ";
print_r($results);

echo "Done\n";
?>
--EXPECT--
Hello from closure
Result: 30
Tasks results: Array
(
    [0] => 1
    [1] => 2
    [2] => 3
)
Done
