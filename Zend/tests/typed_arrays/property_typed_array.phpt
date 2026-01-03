--TEST--
Typed array: property with array<int> type
--FILE--
<?php
declare(strict_arrays=1);

class Counter {
    public array<int> $counts = [];

    public function add(int $n): void {
        $this->counts[] = $n;
    }

    public function getSum(): int {
        return array_sum($this->counts);
    }
}

$c = new Counter();
$c->add(1);
$c->add(2);
$c->add(3);
echo "Sum: " . $c->getSum() . "\n";
var_dump($c->counts);

?>
--EXPECT--
Sum: 6
array(3) {
  [0]=>
  int(1)
  [1]=>
  int(2)
  [2]=>
  int(3)
}
