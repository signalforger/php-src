--TEST--
Constructor promoted property: typed array in promoted property
--FILE--
<?php
declare(strict_arrays=1);

class User {
    public function __construct(
        public int $id,
        public string $name,
        public array<string> $roles = []
    ) {}

    public function hasRole(string $role): bool {
        return in_array($role, $this->roles, true);
    }
}

$admin = new User(1, 'Alice', ['admin', 'editor']);
$guest = new User(2, 'Bob');

echo "{$admin->name} is admin: " . ($admin->hasRole('admin') ? 'yes' : 'no') . "\n";
echo "{$guest->name} is admin: " . ($guest->hasRole('admin') ? 'yes' : 'no') . "\n";

?>
--EXPECT--
Alice is admin: yes
Bob is admin: no
