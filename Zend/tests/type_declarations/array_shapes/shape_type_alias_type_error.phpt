--TEST--
Shape type alias type error
--XLEAK--
--FILE--
<?php

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
--EXPECT--
Caught: getUser(): Return value must be of type array{id: int, ...}, array key "id" is string
