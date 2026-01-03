--TEST--
Typed array: array<string, int> with string keys
--FILE--
<?php
declare(strict_arrays=1);

function getCounts(): array<string, int> {
    return [
        'apples' => 5,
        'oranges' => 3,
        'bananas' => 7
    ];
}

$counts = getCounts();
foreach ($counts as $fruit => $count) {
    echo "$fruit: $count\n";
}

?>
--EXPECT--
apples: 5
oranges: 3
bananas: 7
