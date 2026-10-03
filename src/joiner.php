<?php

declare(strict_types=1);

namespace Joiner;

/**
 * Joins strings with optional conditions.
 *
 * Stringable objects are converted to strings. List arrays are processed
 * recursively; associative array keys and public stdClass properties are
 * included when their values pass the condition.
 *
 * @param array $args Strings, integers, nested lists, and condition maps
 * @param string $separator String inserted between included values
 */
function join(array $args, string $separator = ''): string
{
    $parts = [];

    foreach ($args as $value) {
        if ($value instanceof \Stringable) {
            $value = (string) $value;
        }

        if (is_int($value)) {
            $parts[] = (string) $value;

            continue;
        }

        if (is_string($value)) {
            if ($value !== '') {
                $parts[] = $value;
            }

            continue;
        }

        if (! is_array($value) && ! $value instanceof \stdClass) {
            continue;
        }

        if (is_array($value) && array_is_list($value)) {
            $nested = join($value, $separator);
            if ($nested !== '') {
                $parts[] = $nested;
            }

            continue;
        }

        foreach ($value as $class => $enabled) {
            if (is_string($enabled) ? $enabled !== '' : $enabled) {
                $parts[] = (string) $class;
            }
        }
    }

    return implode($separator, $parts);
}

/**
 * Joins class names and warns when an output token is not a CSS identifier.
 *
 * @param mixed ...$arguments Strings and arrays accepted by join()
 */
function classnames(mixed ...$arguments): string
{
    $classes = join($arguments, ' ');
    $identifier = '~\A(?![0-9])(?!-[0-9])(?:[A-Za-z0-9_-]|[\x{00A0}-\x{10FFFF}]|\\\\(?:[0-9A-Fa-f]{1,6}[ \t\r\n\f]?|[^0-9A-Fa-f\r\n\f]))+\z~u';

    foreach (preg_split('/[ \t\n\f\r]+/', $classes, -1, PREG_SPLIT_NO_EMPTY) as $class) {
        if (preg_match($identifier, $class) !== 1) {
            trigger_error(
                sprintf('Invalid CSS class name %s; expected a CSS <ident>.', var_export($class, true)),
                E_USER_WARNING,
            );
        }
    }

    return $classes;
}
