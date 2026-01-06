--TEST--
Closure type in array shapes - type error (callable but not Closure)
--XLEAK--
--FILE--
<?php

function processWithClosure(array{handler: Closure} $config): mixed {
    return $config['handler']();
}

// Test 1: Function name string (callable but not Closure)
function myFunc(): string {
    return 'hello';
}

try {
    processWithClosure(['handler' => 'myFunc']);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

// Test 2: Static method array (callable but not Closure)
class Helper {
    public static function run(): string {
        return 'helper';
    }
}

try {
    processWithClosure(['handler' => [Helper::class, 'run']]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

// Test 3: Invokable object (callable but not Closure)
class Invokable {
    public function __invoke(): string {
        return 'invoked';
    }
}

try {
    processWithClosure(['handler' => new Invokable()]);
} catch (TypeError $e) {
    echo "TypeError: " . $e->getMessage() . "\n";
}

echo "Done\n";
?>
--EXPECTF--
TypeError: processWithClosure(): Argument #1 ($config) must be of type array{handler: Closure, ...}, array key "handler" is string
TypeError: processWithClosure(): Argument #1 ($config) must be of type array{handler: Closure, ...}, array key "handler" is array
TypeError: processWithClosure(): Argument #1 ($config) must be of type array{handler: Closure, ...}, array key "handler" is Invokable
Done
