--TEST--
Closed array shape - parameter type
--SKIPIF--
<?php if (getenv('USE_ZEND_ALLOC') === '0') die('skip Not compatible with valgrind'); ?>
--FILE--
<?php

function processUser(array{id: int, name: string}! $user): void {
    echo "Processing user: " . $user['name'] . "\n";
}

// Valid: exact match
processUser(['id' => 1, 'name' => 'Alice']);

// Invalid: extra key
try {
    processUser(['id' => 2, 'name' => 'Bob', 'extra' => 'data']);
} catch (TypeError $e) {
    echo $e->getMessage() . "\n";
}

?>
--EXPECTF--
Processing user: Alice
processUser(): Argument #1 ($user) must be of type closed shape, unexpected extra key "extra"%A
