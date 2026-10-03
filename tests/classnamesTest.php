<?php

use function Joiner\classnames;

it('joins valid CSS identifiers without warnings', function () {
    $warnings = [];
    set_error_handler(function (int $severity, string $message) use (&$warnings): bool {
        $warnings[] = [$severity, $message];

        return true;
    });

    try {
        $classes = classnames('btn', 'ground-level', ['--toto' => true], 'scooby\\.doo', '🔥123');
    } finally {
        restore_error_handler();
    }

    expect($classes)->toBe('btn ground-level --toto scooby\\.doo 🔥123')
        ->and($warnings)->toBe([]);
});

it('warns for invalid identifiers without changing the result', function () {
    $warnings = [];
    set_error_handler(function (int $severity, string $message) use (&$warnings): bool {
        $warnings[] = [$severity, $message];

        return true;
    });

    try {
        $classes = classnames('34rem', '-12rad', 'scooby.doo', ['not.valid' => false]);
    } finally {
        restore_error_handler();
    }

    expect($classes)->toBe('34rem -12rad scooby.doo')
        ->and($warnings)->toHaveCount(3)
        ->and(array_column($warnings, 0))->each->toBe(E_USER_WARNING);
});
