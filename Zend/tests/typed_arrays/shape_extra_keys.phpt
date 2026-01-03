--TEST--
Array shape: extra keys beyond shape definition are allowed
--FILE--
<?php

function getUser(): array{id: int, name: string} {
    return [
        'id' => 1,
        'name' => 'Alice',
        'email' => 'alice@example.com',  // Extra key, should be allowed
        'age' => 30                       // Another extra key
    ];
}

$user = getUser();
echo "ID: {$user['id']}\n";
echo "Name: {$user['name']}\n";
echo "Email: {$user['email']}\n";
echo "Age: {$user['age']}\n";

?>
--EXPECT--
ID: 1
Name: Alice
Email: alice@example.com
Age: 30
