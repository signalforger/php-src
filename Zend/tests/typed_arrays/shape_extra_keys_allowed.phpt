--TEST--
Array shape: extra keys beyond defined shape are allowed
--XLEAK--
--FILE--
<?php


function processUser(array{id: int, name: string} $user): void {
    echo "Processing: {$user['name']} (ID: {$user['id']})\n";
    if (isset($user['email'])) {
        echo "  Email: {$user['email']}\n";
    }
}

// Extra 'email' key is allowed - shapes validate required keys exist, not exclusive
processUser(['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com']);

?>
--EXPECT--
Processing: Alice (ID: 1)
  Email: alice@example.com
