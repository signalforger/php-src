--TEST--
Variance: contravariant parameter type - child can accept more general typed array
--FILE--
<?php


class Animal {}
class Dog extends Animal {}

class AnimalProcessor {
    public function process(array<Dog> $dogs): void {
        echo "Processing " . count($dogs) . " dogs\n";
    }
}

class GeneralProcessor extends AnimalProcessor {
    // Contravariant: array<Animal> is more general than array<Dog>
    public function process(array<Animal> $animals): void {
        echo "Processing " . count($animals) . " animals\n";
    }
}

$processor = new GeneralProcessor();
$processor->process([new Dog(), new Dog()]);

?>
--EXPECT--
Processing 2 animals
