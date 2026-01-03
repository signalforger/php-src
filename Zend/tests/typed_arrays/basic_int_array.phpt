--TEST--
Typed array: array<int> basic functionality
--FILE--
<?php
declare(strict_arrays=1);

function getNumbers(): array<int> {
    return [1, 2, 3, 4, 5];
}

function sumNumbers(array<int> $nums): int {
    return array_sum($nums);
}

$nums = getNumbers();
var_dump($nums);
echo "Sum: " . sumNumbers($nums) . "\n";

// Empty array is valid
function emptyInts(): array<int> {
    return [];
}
var_dump(emptyInts());

?>
--EXPECT--
array(5) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
  [3]=>
  int(4)
  [4]=>
  int(5)
}
Sum: 15
array(0) {
}
