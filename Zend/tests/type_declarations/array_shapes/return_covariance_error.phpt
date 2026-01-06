--TEST--
Return type covariance violation - child cannot return wider type
--FILE--
<?php

// Child tries to return FEWER fields than parent (invalid - wider type)
class BaseProvider {
    public function getData(): array{id: int, name: string, email: string} {
        return ['id' => 1, 'name' => 'Test', 'email' => 'test@test.com'];
    }
}

class LooseProvider extends BaseProvider {
    // INVALID: returns fewer required fields (wider type)
    public function getData(): array{id: int} {
        return ['id' => 1];
    }
}
?>
--EXPECTF--
Fatal error: Declaration of LooseProvider::getData(): array{id: int} must be compatible with BaseProvider::getData(): array{id: int, name: string, email: string} in %s on line %d
