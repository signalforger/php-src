--TEST--
Closed array shape - basic validation
--SKIPIF--
<?php if (getenv('USE_ZEND_ALLOC') === '0') die('skip Not compatible with valgrind'); ?>
--FILE--
<?php

// Closed shape: no extra keys allowed
function getUser(): array{id: int, name: string}! {
    return ['id' => 1, 'name' => 'Alice'];
}

$user = getUser();
var_dump($user);

// Verify reflection
$ref = new ReflectionFunction('getUser');
$type = $ref->getReturnType();
var_dump($type->isClosed());
echo $type . "\n";

?>
--EXPECTF--
array(2) {
  ["id"]=>
  int(1)
  ["name"]=>
  string(5) "Alice"
}
bool(true)
array{id: int, name: string}!%A
