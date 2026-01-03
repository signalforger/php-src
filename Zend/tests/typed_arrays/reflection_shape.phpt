--TEST--
Reflection: ReflectionType for array shapes
--FILE--
<?php

function getUser(): array{id: int, name: string} {
    return ['id' => 1, 'name' => 'Alice'];
}

$rf = new ReflectionFunction('getUser');
$returnType = $rf->getReturnType();

echo "Return type: " . $returnType . "\n";
echo "Is built-in: " . ($returnType->isBuiltin() ? 'yes' : 'no') . "\n";

?>
--EXPECT--
Return type: array{id: int, name: string}
Is built-in: yes
