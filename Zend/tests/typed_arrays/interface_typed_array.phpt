--TEST--
Interface: typed array in interface method
--XLEAK--
--FILE--
<?php


interface Repository {
    public function findAll(): array<array{id: int, name: string}>;
    public function save(array{id: int, name: string} $item): void;
}

class UserRepository implements Repository {
    private array<array{id: int, name: string}> $items = [];

    public function findAll(): array<array{id: int, name: string}> {
        return $this->items;
    }

    public function save(array{id: int, name: string} $item): void {
        $this->items[] = $item;
    }
}

$repo = new UserRepository();
$repo->save(['id' => 1, 'name' => 'Alice']);
$repo->save(['id' => 2, 'name' => 'Bob']);

foreach ($repo->findAll() as $user) {
    echo "{$user['id']}: {$user['name']}\n";
}

?>
--EXPECT--
1: Alice
2: Bob
