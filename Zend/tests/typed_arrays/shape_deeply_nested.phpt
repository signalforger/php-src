--TEST--
Array shape: deeply nested shapes work correctly
--XLEAK--
--FILE--
<?php
declare(strict_arrays=1);

function getNestedData(): array{
    level1: array{
        level2: array{
            level3: array{
                value: int
            }
        }
    }
} {
    return [
        'level1' => [
            'level2' => [
                'level3' => [
                    'value' => 42
                ]
            ]
        ]
    ];
}

$data = getNestedData();
echo "Value: " . $data['level1']['level2']['level3']['value'] . "\n";

?>
--EXPECT--
Value: 42
