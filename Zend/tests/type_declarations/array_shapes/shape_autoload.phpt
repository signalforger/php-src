--TEST--
Shape type alias autoloading
--FILE--
<?php
declare(strict_arrays=1);

// Create temporary shape file
$tempDir = sys_get_temp_dir() . '/php_shape_autoload_test_' . getmypid();
mkdir($tempDir);
file_put_contents($tempDir . '/User.php', '<?php
declare(strict_arrays=1);
shape User = array{id: int, name: string};
');

$autoloaded = [];
spl_autoload_register(function($class) use ($tempDir, &$autoloaded) {
    $autoloaded[] = $class;
    $file = "$tempDir/$class.php";
    if (file_exists($file)) {
        require_once $file;
    }
});

// Shape should not exist before autoload
var_dump(shape_exists('User', false));

// Trigger autoload via shape_exists
var_dump(shape_exists('User', true));

// Verify autoloader was called
var_dump($autoloaded);

// Clean up
unlink($tempDir . '/User.php');
rmdir($tempDir);
?>
--EXPECT--
bool(false)
bool(true)
array(1) {
  [0]=>
  string(4) "User"
}
