--TEST--
Reflection: ReflectionType for typed arrays
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

function getNumbers(): array<int> {
    return [1, 2, 3];
}

$rf = new ReflectionFunction('getNumbers');
$returnType = $rf->getReturnType();

echo "Return type: " . $returnType . "\n";
echo "Class: " . get_class($returnType) . "\n";
echo "Allows null: " . ($returnType->allowsNull() ? 'yes' : 'no') . "\n";

?>
--EXPECT--
Return type: array<int>
Class: ReflectionArrayType
Allows null: no
