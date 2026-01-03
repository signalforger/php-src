--TEST--
Array shape: basic array{key: type} functionality
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

function getUser(): array{id: int, name: string, email: string} {
    return [
        'id' => 1,
        'name' => 'Alice',
        'email' => 'alice@example.com'
    ];
}

$user = getUser();
echo "ID: {$user['id']}\n";
echo "Name: {$user['name']}\n";
echo "Email: {$user['email']}\n";

?>
--EXPECT--
ID: 1
Name: Alice
Email: alice@example.com
