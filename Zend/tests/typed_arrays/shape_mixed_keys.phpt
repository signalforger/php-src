--TEST--
Array shape: mixed required and optional keys
--XLEAK--
--FILE--
<?php


function createUser(
    array{
        id: int,
        name: string,
        email?: string,
        age?: int,
        active: bool
    } $data
): void {
    echo "User: {$data['name']} (ID: {$data['id']})\n";
    if (isset($data['email'])) {
        echo "  Email: {$data['email']}\n";
    }
    if (isset($data['age'])) {
        echo "  Age: {$data['age']}\n";
    }
    echo "  Active: " . ($data['active'] ? 'yes' : 'no') . "\n";
}

// All fields
createUser([
    'id' => 1,
    'name' => 'Alice',
    'email' => 'alice@example.com',
    'age' => 30,
    'active' => true
]);

echo "---\n";

// Only required fields
createUser([
    'id' => 2,
    'name' => 'Bob',
    'active' => false
]);

?>
--EXPECT--
User: Alice (ID: 1)
  Email: alice@example.com
  Age: 30
  Active: yes
---
User: Bob (ID: 2)
  Active: no
