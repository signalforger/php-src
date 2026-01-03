--TEST--
Variance: covariant return type - child can return more specific typed array
--FILE--
<?php
declare(strict_arrays=1);

class Animal {}
class Dog extends Animal {}
class Cat extends Animal {}

class AnimalShelter {
    public function getAnimals(): array<Animal> {
        return [new Animal(), new Animal()];
    }
}

class DogShelter extends AnimalShelter {
    // Covariant: array<Dog> is more specific than array<Animal>
    public function getAnimals(): array<Dog> {
        return [new Dog(), new Dog()];
    }
}

$shelter = new DogShelter();
$dogs = $shelter->getAnimals();
echo "Got " . count($dogs) . " dogs\n";
echo "First is Dog: " . ($dogs[0] instanceof Dog ? 'yes' : 'no') . "\n";

?>
--EXPECT--
Got 2 dogs
First is Dog: yes
