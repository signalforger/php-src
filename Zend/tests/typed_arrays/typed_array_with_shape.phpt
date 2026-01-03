--TEST--
Typed array: array<shape> combining typed arrays with shapes
--FILE--
<?php

function getUsers(): array<array{id: int, name: string}> {
    return [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
        ['id' => 3, 'name' => 'Charlie'],
    ];
}

$users = getUsers();
echo "Found " . count($users) . " users:\n";
foreach ($users as $user) {
    echo "  - {$user['name']} (ID: {$user['id']})\n";
}

?>
--EXPECT--
Found 3 users:
  - Alice (ID: 1)
  - Bob (ID: 2)
  - Charlie (ID: 3)
