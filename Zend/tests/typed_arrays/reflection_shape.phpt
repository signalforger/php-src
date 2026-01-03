--TEST--
Reflection: ReflectionType for array shapes
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

function getUser(): array{id: int, name: string} {
    return ['id' => 1, 'name' => 'Alice'];
}

$rf = new ReflectionFunction('getUser');
$returnType = $rf->getReturnType();

echo "Return type: " . $returnType . "\n";
echo "Class: " . get_class($returnType) . "\n";

?>
--EXPECT--
Return type: array{id: int, name: string}
Class: ReflectionArrayShapeType
