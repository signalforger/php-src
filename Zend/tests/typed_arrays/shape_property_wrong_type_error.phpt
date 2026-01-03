--TEST--
Array shape: property assignment wrong type error
--XLEAK--
--FILE--
<?php


class User {
    public array{id: int, name: string} $user;
}

$u = new User();

// Valid assignment
$u->user = ['id' => 1, 'name' => 'Alice'];
echo "Valid assignment: OK\n";

// Invalid assignment - wrong type for 'id'
try {
    $u->user = ['id' => 'one', 'name' => 'Alice'];
} catch (TypeError $e) {
    echo "Wrong type: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Valid assignment: OK
Wrong type: Cannot assign to property User::$user of type array{id: int, ...}, array key "id" is string
