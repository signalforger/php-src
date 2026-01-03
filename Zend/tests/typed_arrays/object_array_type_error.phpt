--TEST--
Typed array: array<ClassName> type error with wrong object type
--FILE--
<?php

class User {
    public function __construct(public int $id) {}
}

class Product {
    public function __construct(public int $id) {}
}

function getUsers(): array<User> {
    return [
        new User(1),
        new Product(2),  // Wrong type!
    ];
}

try {
    getUsers();
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Caught: getUsers(): Return value must be of type array<User>, array containing Product given
