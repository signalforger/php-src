--TEST--
Namespaced shape type aliases with autoloading
--XLEAK--
--FILE--
<?php

// Create temporary directory structure for namespaced shapes
$tempDir = sys_get_temp_dir() . '/php_shape_ns_test_' . getmypid();
mkdir($tempDir . '/App/Shapes', 0755, true);
mkdir($tempDir . '/App/Services', 0755, true);

// Create namespaced shape file
file_put_contents($tempDir . '/App/Shapes/UserShape.php', '<?php
namespace App\Shapes;

shape UserShape = array{id: int, name: string, email: string};
');

// Create service that uses the namespaced shape
file_put_contents($tempDir . '/App/Services/UserService.php', '<?php
namespace App\Services;

use App\Shapes\UserShape;

class UserService {
    public function getUser(int $id): UserShape {
        return ["id" => $id, "name" => "Alice", "email" => "alice@example.com"];
    }

    public function processUser(UserShape $user): string {
        return "Processing: " . $user["name"];
    }
}
');

// Register PSR-4 style autoloader
$autoloaded = [];
spl_autoload_register(function($name) use ($tempDir, &$autoloaded) {
    $autoloaded[] = $name;
    $file = $tempDir . '/' . str_replace('\\', '/', $name) . '.php';
    if (file_exists($file)) {
        require_once $file;
        return true;
    }
    return false;
});

// Test 1: shape_exists with namespaced shape (no autoload)
echo "Before autoload (no trigger): ";
var_dump(shape_exists('App\Shapes\UserShape', false));

// Test 2: shape_exists with namespaced shape (with autoload)
echo "With autoload trigger: ";
var_dump(shape_exists('App\Shapes\UserShape', true));

// Test 3: Use namespaced shape in class method
$service = new App\Services\UserService();
$user = $service->getUser(42);
echo "User ID: " . $user['id'] . ", Name: " . $user['name'] . "\n";

// Test 4: Shape as parameter type
echo $service->processUser($user) . "\n";

// Test 5: Verify autoloader was called for both shape and class
echo "Autoloaded:\n";
foreach ($autoloaded as $name) {
    echo "  - $name\n";
}

// Clean up
unlink($tempDir . '/App/Shapes/UserShape.php');
unlink($tempDir . '/App/Services/UserService.php');
rmdir($tempDir . '/App/Services');
rmdir($tempDir . '/App/Shapes');
rmdir($tempDir . '/App');
rmdir($tempDir);
echo "Done\n";
?>
--EXPECT--
Before autoload (no trigger): bool(false)
With autoload trigger: bool(true)
User ID: 42, Name: Alice
Processing: Alice
Autoloaded:
  - App\Shapes\UserShape
  - App\Services\UserService
Done
