--TEST--
Typed array: array<ClassName> with objects
--FILE--
<?php


class User {
    public function __construct(
        public int $id,
        public string $name
    ) {}
}

function getUsers(): array<User> {
    return [
        new User(1, "Alice"),
        new User(2, "Bob"),
    ];
}

function processUsers(array<User> $users): void {
    foreach ($users as $user) {
        echo "User {$user->id}: {$user->name}\n";
    }
}

$users = getUsers();
processUsers($users);

?>
--EXPECT--
User 1: Alice
User 2: Bob
