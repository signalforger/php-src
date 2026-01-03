--TEST--
Edge case: array shape with named arguments
--XLEAK--
--FILE--
<?php


function createUser(array{id: int, name: string, active?: bool} $data): void {
    echo "User: {$data['id']} - {$data['name']}";
    if (isset($data['active'])) {
        echo " (active: " . ($data['active'] ? 'yes' : 'no') . ")";
    }
    echo "\n";
}

// Named arguments at call site with array literal
createUser(data: ['id' => 1, 'name' => 'Alice']);
createUser(data: ['id' => 2, 'name' => 'Bob', 'active' => true]);

?>
--EXPECT--
User: 1 - Alice
User: 2 - Bob (active: yes)
