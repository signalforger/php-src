--TEST--
Typed array: array<string> basic functionality
--FILE--
<?php


function getNames(): array<string> {
    return ["Alice", "Bob", "Charlie"];
}

function joinNames(array<string> $names): string {
    return implode(", ", $names);
}

$names = getNames();
var_dump($names);
echo "Names: " . joinNames($names) . "\n";

?>
--EXPECT--
array(3) {
  [0]=>
  string(5) "Alice"
  [1]=>
  string(3) "Bob"
  [2]=>
  string(7) "Charlie"
}
Names: Alice, Bob, Charlie
