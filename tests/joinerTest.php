<?php

use function Joiner\join;

it('joins strings and integers while ignoring other scalar values', function () {
    expect(join(['one', false, null, 0, 12, '', 'two'], ' '))->toBe('one 0 12 two');
});

it('converts integer values and conditional map keys to strings', function () {
    expect(join([12, ['13', 14], [15 => true, 16 => false], (object) ['17' => true]], ','))
        ->toBe('12,13,14,15,17');
});

it('joins objects that implement __toString()', function () {
    $stringable = new class {
        public function __toString(): string
        {
            return 'stringable';
        }
    };

    expect(join(['before', $stringable, ['after']], ' '))->toBe('before stringable after');
});

it('defaults to an empty separator', function () {
    expect(join(args: ['one', 'two']))->toBe('onetwo');
});

it('accepts named parameters', function () {
    expect(join(args: ['one', 'two'], separator: '-'))->toBe('one-two');
});

it('recursively joins list arrays', function () {
    expect(join(['one', ['two', null], 'three'], '-'))->toBe('one-two-three');
});

it('includes associative array keys with truthy values', function () {
    expect(join([['one' => true, 'two' => false, 'three' => 1]], ' '))->toBe('one three');
});

it('uses non-empty strings and PHP truthiness for map conditions', function () {
    expect(join([[
        'zero' => 0,
        'float-zero' => 0.0,
        'string-zero' => '0',
        'empty-string' => '',
        'empty-list' => [],
        'not-a-number' => NAN,
        'non-empty-list' => ['value'],
        'false' => false,
        'true' => true,
    ]], ' '))->toBe('string-zero not-a-number non-empty-list true');
});

it('supports mixed arguments and nested conditional maps', function () {
    expect(join(['base', ['active' => true, 'hidden' => false], ['extra', ['last' => true]]], ' '))
        ->toBe('base active extra last');
});
