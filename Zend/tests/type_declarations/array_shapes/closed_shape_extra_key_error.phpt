--TEST--
Closed array shape - extra key error
--SKIPIF--
<?php if (getenv('USE_ZEND_ALLOC') === '0') die('skip Not compatible with valgrind'); ?>
--FILE--
<?php

function getUser(): array{id: int, name: string}! {
    return ['id' => 1, 'name' => 'Alice', 'extra' => 'not allowed'];
}

try {
    getUser();
} catch (TypeError $e) {
    echo $e->getMessage() . "\n";
}

?>
--EXPECTF--
getUser(): Return value must be of type closed shape, unexpected extra key "extra"%A
