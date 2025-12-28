--TEST--
Array shape in class methods
--FILE--
<?php
declare(strict_arrays=1);

class UserService {
    public function createUser(array{name: string, email: string} $data): array{id: int, name: string, email: string} {
        return [
            'id' => 1,
            'name' => $data['name'],
            'email' => $data['email']
        ];
    }
}

$service = new UserService();
$user = $service->createUser(['name' => 'Alice', 'email' => 'alice@example.com']);
echo "Created user: {$user['name']} (ID: {$user['id']})\n";

?>
--EXPECT--
Created user: Alice (ID: 1)
