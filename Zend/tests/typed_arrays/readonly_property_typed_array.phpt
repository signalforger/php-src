--TEST--
Readonly property: typed array in readonly property
--FILE--
<?php


class ImmutableConfig {
    public function __construct(
        public readonly array<string> $allowedHosts
    ) {}
}

$config = new ImmutableConfig(['localhost', 'example.com']);
echo "Allowed hosts: " . implode(", ", $config->allowedHosts) . "\n";

?>
--EXPECT--
Allowed hosts: localhost, example.com
