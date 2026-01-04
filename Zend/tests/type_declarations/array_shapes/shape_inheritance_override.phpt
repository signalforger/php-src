--TEST--
Shape inheritance - child overrides parent property type
--XLEAK--
--FILE--
<?php

shape Base = array{id: int, value: string};
shape Child extends Base = array{value: int};  // Override value from string to int

function test(Child $data): void {
    var_dump($data);
}

// value is now int, not string
test(['id' => 1, 'value' => 42]);

echo "Done\n";
?>
--EXPECT--
array(2) {
  ["id"]=>
  int(1)
  ["value"]=>
  int(42)
}
Done
