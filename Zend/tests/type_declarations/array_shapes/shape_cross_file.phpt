--TEST--
Shape type alias cross-file usage via require
--XLEAK--
--FILE--
<?php
// Create temporary shape file
$tempDir = sys_get_temp_dir() . '/php_shape_test_' . getmypid();
mkdir($tempDir);
file_put_contents($tempDir . '/shapes.php', '<?php
shape User = array{id: int, name: string};
shape Address = array{street: string, city: string};
');

$mainCode = <<<'MAIN'
<?php
require_once "%s/shapes.php";

function getUser(): User {
    return ["id" => 1, "name" => "Bob"];
}

function getAddress(): Address {
    return ["street" => "123 Main St", "city" => "NYC"];
}

$user = getUser();
$address = getAddress();

echo "User: " . $user["name"] . "\n";
echo "Address: " . $address["street"] . ", " . $address["city"] . "\n";
MAIN;

file_put_contents($tempDir . '/main.php', sprintf($mainCode, $tempDir));

include $tempDir . '/main.php';

// Clean up
unlink($tempDir . '/shapes.php');
unlink($tempDir . '/main.php');
rmdir($tempDir);
?>
--EXPECT--
User: Bob
Address: 123 Main St, NYC
