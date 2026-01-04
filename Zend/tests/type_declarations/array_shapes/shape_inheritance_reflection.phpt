--TEST--
Shape inheritance - reflection shows flattened structure
--XLEAK--
--FILE--
<?php

shape BaseShape = array{id: int, name: string};
shape ExtendedShape extends BaseShape = array{email: string};

$rf = new ReflectionFunction(function(ExtendedShape $arg) {});
$params = $rf->getParameters();
$type = $params[0]->getType();

echo "Type string: " . $type . "\n";
echo "Element count: " . $type->getElementCount() . "\n";
echo "Required count: " . $type->getRequiredElementCount() . "\n";

echo "\nElements:\n";
foreach ($type->getElements() as $elem) {
    echo "  - " . $elem->getName() . ": " . $elem->getType() . "\n";
}

echo "Done\n";
?>
--EXPECT--
Type string: array{id: int, name: string, email: string}
Element count: 3
Required count: 3

Elements:
  - id: int
  - name: string
  - email: string
Done
