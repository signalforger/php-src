--TEST--
Reflection: ReflectionType for typed arrays
--FILE--
<?php

function getNumbers(): array<int> {
    return [1, 2, 3];
}

$rf = new ReflectionFunction('getNumbers');
$returnType = $rf->getReturnType();

echo "Return type: " . $returnType . "\n";
echo "Is built-in: " . ($returnType->isBuiltin() ? 'yes' : 'no') . "\n";
echo "Allows null: " . ($returnType->allowsNull() ? 'yes' : 'no') . "\n";

?>
--EXPECT--
Return type: array<int>
Is built-in: yes
Allows null: no
