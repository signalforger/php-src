--TEST--
Shape type alias type error
--FILE--
<?php
declare(strict_arrays=1);

shape User = array{id: int, name: string};

function getUser(): User {
    return ["id" => "not-an-int", "name" => "John"];
}

try {
    getUser();
} catch (TypeError $e) {
    echo "Caught: " . $e->getMessage() . "\n";
}
?>
--EXPECTF--
Caught: getUser(): Return value key "id" must be of type int, string given
