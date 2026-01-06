--TEST--
Shape inheritance - valid type covariance
--XLEAK--
--FILE--
<?php

// Test 1: Child can narrow union type to single type
shape BaseUnion = array{id: int, value: string|int};
shape ChildNarrow extends BaseUnion = array{value: string};  // Valid: string|int -> string

function testNarrow(ChildNarrow $data): void {
    echo "value type narrowed: ";
    var_dump($data['value']);
}
testNarrow(['id' => 1, 'value' => 'hello']);

// Test 2: Child can keep same type
shape BaseSame = array{id: int, name: string};
shape ChildSame extends BaseSame = array{name: string};  // Valid: same type

function testSame(ChildSame $data): void {
    echo "value type same: ";
    var_dump($data['name']);
}
testSame(['id' => 2, 'name' => 'Alice']);

// Test 3: Child can make optional required (valid)
shape BaseOptional = array{id: int, status?: string};
shape ChildRequired extends BaseOptional = array{status: string};  // Valid: optional -> required

function testRequired(ChildRequired $data): void {
    echo "optional made required: ";
    var_dump($data['status']);
}
testRequired(['id' => 3, 'status' => 'active']);

// Test 4: Child can add new properties
shape BaseMinimal = array{id: int};
shape ChildExtended extends BaseMinimal = array{name: string, email: string};

function testExtended(ChildExtended $data): void {
    echo "extended with new props: ";
    var_dump($data['name']);
}
testExtended(['id' => 4, 'name' => 'Bob', 'email' => 'bob@example.com']);

echo "Done\n";
?>
--EXPECT--
value type narrowed: string(5) "hello"
value type same: string(5) "Alice"
optional made required: string(6) "active"
extended with new props: string(3) "Bob"
Done
