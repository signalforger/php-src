--TEST--
Edge case: empty array shape (no fields)
--FILE--
<?php
declare(strict_arrays=1);

// Empty shape - accepts any array but provides no type guarantees
function processEmpty(array{} $data): void {
    echo "Got array with " . count($data) . " elements\n";
}

processEmpty([]);
processEmpty(['extra' => 'data']);

?>
--EXPECT--
Got array with 0 elements
Got array with 1 elements
