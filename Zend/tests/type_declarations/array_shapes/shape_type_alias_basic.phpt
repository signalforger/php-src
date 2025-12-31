--TEST--
Shape type alias basic usage
--FILE--
<?php
declare(strict_arrays=1);

shape User = array{id: int, name: string};

function getUser(): User {
    return ["id" => 1, "name" => "John"];
}

function greetUser(User $user): string {
    return "Hello, " . $user["name"];
}

$user = getUser();
var_dump($user);
echo greetUser($user) . "\n";
?>
--EXPECT--
array(2) {
  ["id"]=>
  int(1)
  ["name"]=>
  string(4) "John"
}
Hello, John
