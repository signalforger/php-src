--TEST--
Typed array: nullable array<int>|null
--FILE--
<?php

function maybeGetNumbers(): ?array<int> {
    return null;
}

function maybeGetNumbers2(): ?array<int> {
    return [1, 2, 3];
}

var_dump(maybeGetNumbers());
var_dump(maybeGetNumbers2());

?>
--EXPECT--
NULL
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
}
