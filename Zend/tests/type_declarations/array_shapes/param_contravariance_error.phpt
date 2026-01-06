--TEST--
Parameter contravariance violation - child cannot accept narrower type
--FILE--
<?php

// Child tries to require MORE fields than parent (invalid - narrower type)
class BaseHandler {
    public function handle(array{id: int} $data): void {
        echo "Handled\n";
    }
}

class StrictHandler extends BaseHandler {
    // INVALID: requires more fields than parent (narrower type)
    public function handle(array{id: int, name: string, email: string} $data): void {
        echo "Strictly handled\n";
    }
}
?>
--EXPECTF--
Fatal error: Declaration of StrictHandler::handle(array{id: int, name: string, email: string} $data): void must be compatible with BaseHandler::handle(array{id: int} $data): void in %s on line %d
