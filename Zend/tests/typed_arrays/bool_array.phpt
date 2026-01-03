--TEST--
Typed array: array<bool> functionality
--FILE--
<?php

function getFlags(): array<bool> {
    return [true, false, true, true];
}

$flags = getFlags();
$trueCount = count(array_filter($flags));
echo "True count: $trueCount out of " . count($flags) . "\n";

?>
--EXPECT--
True count: 3 out of 4
