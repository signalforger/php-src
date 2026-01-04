--TEST--
Shape inheritance - nested/chained inheritance
--XLEAK--
--FILE--
<?php

shape Base = array{a: int};
shape Middle extends Base = array{b: string};
shape Top extends Middle = array{c: bool};

function test(Top $data): void {
    echo "a=" . $data['a'] . ", b=" . $data['b'] . ", c=" . ($data['c'] ? 'true' : 'false') . "\n";
}

test(['a' => 42, 'b' => 'hello', 'c' => true]);
test(['a' => 100, 'b' => 'world', 'c' => false]);

echo "Done\n";
?>
--EXPECT--
a=42, b=hello, c=true
a=100, b=world, c=false
Done
