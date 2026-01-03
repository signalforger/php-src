--TEST--
Array shape: error when required key is missing
--FILE--
<?php

function getUser(): array{id: int, name: string} {
    return [
        'id' => 1
        // 'name' is required but missing
    ];
}

try {
    getUser();
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}

?>
--EXPECTF--
Caught: getUser(): Return value must be of type array{%s: ...}, missing required key "name"
