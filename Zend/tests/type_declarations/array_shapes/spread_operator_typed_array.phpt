--TEST--
Spread operator with typed arrays
--XLEAK--
--FILE--
<?php

// Test 1: Basic spread with typed array
function getNumbers(): array<int> {
    return [1, 2, 3];
}

$numbers = getNumbers();
$combined = [0, ...$numbers, 4, 5];
echo "Combined: ";
print_r($combined);

// Test 2: Spread typed array into function accepting typed array
function sumAll(array<int> $nums): int {
    return array_sum($nums);
}

$base = [10, 20];
$more = [30, 40];
echo "Sum: " . sumAll([...$base, ...$more]) . "\n";

// Test 3: Spread in array shape context
function processData(array{items: array<int>} $data): int {
    return array_sum($data['items']);
}

$items = [1, 2, 3];
$result = processData(['items' => [...$items, 4, 5]]);
echo "Processed: $result\n";

// Test 4: Multiple spreads
$a = [1, 2];
$b = [3, 4];
$c = [5, 6];
$all = [...$a, ...$b, ...$c];
echo "All count: " . count($all) . "\n";

echo "Done\n";
?>
--EXPECT--
Combined: Array
(
    [0] => 0
    [1] => 1
    [2] => 2
    [3] => 3
    [4] => 4
    [5] => 5
)
Sum: 100
Processed: 15
All count: 6
Done
