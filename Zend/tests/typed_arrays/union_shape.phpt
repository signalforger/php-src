--TEST--
Union types: array shape in union with null
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

function findUser(int $id): array{id: int, name: string}|null {
    if ($id === 1) {
        return ['id' => 1, 'name' => 'Alice'];
    }
    return null;
}

$user = findUser(1);
echo "Found: " . ($user ? $user['name'] : "nobody") . "\n";

$nobody = findUser(999);
echo "Found: " . ($nobody ? $nobody['name'] : "nobody") . "\n";

?>
--EXPECT--
Found: Alice
Found: nobody
