--TEST--
Parameter contravariance with array shapes - child accepts wider types
--XLEAK--
--FILE--
<?php

// Test 1: Child class accepts wider array shape (fewer required fields)
class BaseProcessor {
    public function process(array{id: int, name: string, email: string} $data): void {
        echo "Base processing: {$data['id']}\n";
    }
}

class FlexibleProcessor extends BaseProcessor {
    // Contravariant: accepts wider type (fewer required fields)
    public function process(array{id: int} $data): void {
        echo "Flexible processing: {$data['id']}\n";
    }
}

$processor = new FlexibleProcessor();
$processor->process(['id' => 1, 'name' => 'Test', 'email' => 'test@test.com']);
$processor->process(['id' => 2]); // Would fail on parent, works on child

// Test 2: Interface implementation with wider parameter type
interface StrictHandler {
    public function handle(array{action: string, payload: array{id: int}} $request): void;
}

class LenientHandler implements StrictHandler {
    // Accepts wider type - payload only needs to be an array
    public function handle(array{action: string, payload: array} $request): void {
        echo "Handling action: {$request['action']}\n";
    }
}

$handler = new LenientHandler();
$handler->handle(['action' => 'create', 'payload' => ['id' => 1]]);
$handler->handle(['action' => 'update', 'payload' => ['any' => 'data']]);

// Test 3: Abstract class with contravariant parameter
abstract class AbstractValidator {
    abstract public function validate(array{name: string, age: int, email: string} $data): bool;
}

class SimpleValidator extends AbstractValidator {
    // Accepts any array - widest possible type
    public function validate(array $data): bool {
        echo "Validating data with " . count($data) . " fields\n";
        return true;
    }
}

$validator = new SimpleValidator();
$validator->validate(['name' => 'John']);
$validator->validate(['name' => 'Jane', 'age' => 30, 'email' => 'jane@example.com', 'extra' => 'field']);

// Test 4: Typed array contravariance - child accepts any array
class TypedArrayProcessor {
    public function sum(array<int> $numbers): int {
        return array_sum($numbers);
    }
}

class AnyArrayProcessor extends TypedArrayProcessor {
    // Accepts any array (contravariant)
    public function sum(array $numbers): int {
        return array_sum($numbers);
    }
}

$anyProcessor = new AnyArrayProcessor();
echo "Sum: " . $anyProcessor->sum([1, 2, 3]) . "\n";

echo "Done\n";
?>
--EXPECT--
Flexible processing: 1
Flexible processing: 2
Handling action: create
Handling action: update
Validating data with 1 fields
Validating data with 4 fields
Sum: 6
Done
