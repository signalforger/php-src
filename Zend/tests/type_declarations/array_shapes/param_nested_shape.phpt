--TEST--
Array shape as parameter type - nested shapes
--FILE--
<?php
declare(strict_arrays=1);

function processUser(array{
    id: int,
    profile: array{name: string, email: string}
} $user): string {
    return $user['profile']['name'] . ' <' . $user['profile']['email'] . '>';
}

$user = [
    'id' => 1,
    'profile' => [
        'name' => 'Alice',
        'email' => 'alice@example.com'
    ]
];

echo processUser($user) . "\n";

?>
--EXPECT--
Alice <alice@example.com>
