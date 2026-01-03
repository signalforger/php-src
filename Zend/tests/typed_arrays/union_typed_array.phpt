--TEST--
Union types: typed array in union with null
--FILE--
<?php
declare(strict_arrays=1);

function getNumbers(): array<int>|null {
    return [1, 2, 3];
}

function getNothing(): array<int>|null {
    return null;
}

$nums = getNumbers();
echo "Numbers: " . ($nums ? implode(", ", $nums) : "none") . "\n";

$nothing = getNothing();
echo "Nothing: " . ($nothing ? implode(", ", $nothing) : "none") . "\n";

?>
--EXPECT--
Numbers: 1, 2, 3
Nothing: none
