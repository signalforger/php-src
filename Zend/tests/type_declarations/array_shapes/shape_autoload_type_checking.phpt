--TEST--
Shape type alias autoloading with type checking
--XFAIL--
Shape autoloading via spl_autoload is not yet implemented in zend_lookup_shape_ex
--XLEAK--
--FILE--
<?php

// Create temporary shape file
$tempDir = sys_get_temp_dir() . '/php_shape_autoload_test_' . getmypid();
mkdir($tempDir);
file_put_contents($tempDir . '/User.php', '<?php
shape User = array{id: int, name: string};
');

spl_autoload_register(function($class) use ($tempDir) {
    $file = "$tempDir/$class.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

// Define function using the shape type
function getUser(): User {
    return ["id" => 1, "name" => "Alice"];
}

function processUser(User $user): void {
    echo "Processing user: {$user['name']}\n";
}

// Use the functions - should trigger autoload and work correctly
$user = getUser();
var_dump($user);
processUser($user);

// Clean up
unlink($tempDir . '/User.php');
rmdir($tempDir);
?>
--EXPECT--
array(2) {
  ["id"]=>
  int(1)
  ["name"]=>
  string(5) "Alice"
}
Processing user: Alice
