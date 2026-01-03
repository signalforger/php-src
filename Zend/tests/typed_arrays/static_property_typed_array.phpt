--TEST--
Static property: typed array in static class property
--FILE--
<?php


class Registry {
    private static array<string> $items = [];

    public static function add(string $item): void {
        self::$items[] = $item;
    }

    public static function getAll(): array<string> {
        return self::$items;
    }

    public static function clear(): void {
        self::$items = [];
    }
}

Registry::add("item1");
Registry::add("item2");
echo "Items: " . implode(", ", Registry::getAll()) . "\n";

Registry::clear();
echo "After clear: " . count(Registry::getAll()) . " items\n";

?>
--EXPECT--
Items: item1, item2
After clear: 0 items
