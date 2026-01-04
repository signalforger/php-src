--TEST--
Shape inheritance - basic extends syntax
--XLEAK--
--FILE--
<?php

shape BaseShape = array{id: int, name: string};
shape ExtendedShape extends BaseShape = array{email: string};

function test(ExtendedShape $data): void {
    var_dump($data);
}

// Test with all required fields from both parent and child
test(['id' => 1, 'name' => 'John', 'email' => 'john@example.com']);

// Test that parent fields are accessible
function getParentFields(ExtendedShape $data): array {
    return ['id' => $data['id'], 'name' => $data['name']];
}

var_dump(getParentFields(['id' => 2, 'name' => 'Jane', 'email' => 'jane@example.com']));

echo "Done\n";
?>
--EXPECT--
array(3) {
  ["id"]=>
  int(1)
  ["name"]=>
  string(4) "John"
  ["email"]=>
  string(16) "john@example.com"
}
array(2) {
  ["id"]=>
  int(2)
  ["name"]=>
  string(4) "Jane"
}
Done
