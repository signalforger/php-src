--TEST--
Readonly property: typed array in readonly property
--FILE--
<?php
declare(strict_arrays=1);

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
