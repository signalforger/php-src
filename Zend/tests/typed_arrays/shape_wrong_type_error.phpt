--TEST--
Array shape: error when key has wrong type
--FILE--
<?php

function getUser(): array{id: int, name: string} {
    return [
        'id' => "not_an_int",  // Wrong type!
        'name' => 'Alice'
    ];
}

try {
    getUser();
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Caught: getUser(): Return value key "id" must be of type int, string given
