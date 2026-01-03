--TEST--
Typed array: empty array is valid for any typed array
--XLEAK--
--FILE--
<?php


function getInts(): array<int> {
    return [];
}

function getStrings(): array<string> {
    return [];
}

function getUsers(): array<array{id: int, name: string}> {
    return [];
}

var_dump(getInts());
var_dump(getStrings());
var_dump(getUsers());

?>
--EXPECT--
array(0) {
}
array(0) {
}
array(0) {
}
