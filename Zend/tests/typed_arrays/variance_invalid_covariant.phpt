--TEST--
Variance: valid covariant return - child can return more specific type
--XLEAK--
--FILE--
<?php


class Animal {}
class Dog extends Animal {}

class AnimalShelter {
    public function getAnimals(): array<Animal> {
        return [new Animal()];
    }
}

class DogShelter extends AnimalShelter {
    // Valid: array<Dog> is more specific than array<Animal> for return types
    public function getAnimals(): array<Dog> {
        return [new Dog()];
    }
}

$shelter = new DogShelter();
$dogs = $shelter->getAnimals();
echo "Got " . count($dogs) . " dogs\n";

?>
--EXPECT--
Got 1 dogs
