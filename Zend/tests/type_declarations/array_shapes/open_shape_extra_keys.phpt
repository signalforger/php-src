--TEST--
Open array shape - extra keys allowed (default)
--SKIPIF--
<?php if (getenv('USE_ZEND_ALLOC') === '0') die('skip Not compatible with valgrind'); ?>
--FILE--
<?php

// Open shape (default): extra keys are allowed
function getUser(): array{id: int, name: string} {
    return ['id' => 1, 'name' => 'Alice', 'extra' => 'allowed', 'more' => 'data'];
}

$user = getUser();
var_dump($user);

// Verify reflection shows not closed
$ref = new ReflectionFunction('getUser');
$type = $ref->getReturnType();
var_dump($type->isClosed());
echo $type . "\n";

?>
--EXPECTF--
array(4) {
  ["id"]=>
  int(1)
  ["name"]=>
  string(5) "Alice"
  ["extra"]=>
  string(7) "allowed"
  ["more"]=>
  string(4) "data"
}
bool(false)
array{id: int, name: string}%A
