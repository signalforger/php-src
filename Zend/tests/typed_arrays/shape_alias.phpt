--TEST--
Shape alias: using shape keyword to define reusable types
--XLEAK--
--FILE--
<?php


shape User = array{id: int, name: string, email: string};

function createUser(int $id, string $name, string $email): User {
    return [
        'id' => $id,
        'name' => $name,
        'email' => $email
    ];
}

function getUsers(): array<User> {
    return [
        createUser(1, 'Alice', 'alice@example.com'),
        createUser(2, 'Bob', 'bob@example.com'),
    ];
}

$users = getUsers();
foreach ($users as $user) {
    echo "{$user['name']} <{$user['email']}>\n";
}

?>
--EXPECT--
Alice <alice@example.com>
Bob <bob@example.com>
