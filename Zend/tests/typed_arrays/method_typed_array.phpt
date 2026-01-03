--TEST--
Typed array: class method with typed array return and parameter
--FILE--
<?php

class UserRepository {
    private array<array{id: int, name: string}> $users = [];

    public function add(array{id: int, name: string} $user): void {
        $this->users[] = $user;
    }

    public function getAll(): array<array{id: int, name: string}> {
        return $this->users;
    }

    public function getIds(): array<int> {
        return array_column($this->users, 'id');
    }
}

$repo = new UserRepository();
$repo->add(['id' => 1, 'name' => 'Alice']);
$repo->add(['id' => 2, 'name' => 'Bob']);

echo "Users:\n";
foreach ($repo->getAll() as $user) {
    echo "  - {$user['name']}\n";
}

echo "IDs: " . implode(", ", $repo->getIds()) . "\n";

?>
--EXPECT--
Users:
  - Alice
  - Bob
IDs: 1, 2
