--TEST--
Shape type alias with nested shapes
--XLEAK--
--FILE--
<?php

shape Address = array{street: string, city: string, zip: string};
shape Person = array{name: string, address: Address};

function getPerson(): Person {
    return [
        "name" => "John Doe",
        "address" => [
            "street" => "123 Main St",
            "city" => "Springfield",
            "zip" => "12345"
        ]
    ];
}

$person = getPerson();
echo $person["name"] . " lives at " . $person["address"]["street"] . "\n";
?>
--EXPECT--
John Doe lives at 123 Main St
