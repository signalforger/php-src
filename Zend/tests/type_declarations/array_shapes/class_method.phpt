--TEST--
Array shape in class methods
--XLEAK--
--FILE--
<?php

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
