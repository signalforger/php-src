--TEST--
Variance: valid contravariant parameter - child can accept more general type
--XLEAK--
--FILE--
<?php


class Animal {}
class Dog extends Animal {}

class DogProcessor {
    public function process(array<Dog> $dogs): void {
        echo "Processing dogs\n";
    }
}

class AnimalProcessor extends DogProcessor {
    // Valid: array<Animal> is more general than array<Dog> for parameters
    public function process(array<Animal> $animals): void {
        echo "Processing animals\n";
    }
}

$processor = new AnimalProcessor();
$processor->process([new Dog()]);

?>
--EXPECT--
Processing animals
