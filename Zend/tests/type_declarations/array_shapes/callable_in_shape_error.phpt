--TEST--
Callable type in array shapes - type error
--XLEAK--
--FILE--
<?php

function processWithCallback(array{callback: callable} $config): void {
    ($config['callback'])();
}

// Test 1: Non-callable value
try {
    processWithCallback(['callback' => 'not_a_real_function']);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

// Test 2: Integer instead of callable
try {
    processWithCallback(['callback' => 123]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

// Test 3: Array that's not a valid callable
try {
    processWithCallback(['callback' => ['NotAClass', 'notAMethod']]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

echo "Done\n";
?>
--EXPECTF--
TypeError: processWithCallback(): Argument #1 ($config) must be of type array{callback: callable, ...}, array key "callback" is string
TypeError: processWithCallback(): Argument #1 ($config) must be of type array{callback: callable, ...}, array key "callback" is int
TypeError: processWithCallback(): Argument #1 ($config) must be of type array{callback: callable, ...}, array key "callback" is array
Done
