# joiner

Join strings with conditions attached to values or array keys.

## Installation

```sh
composer require 26b/joiner
```

Requires PHP 8.3 or later.

## Usage

```php
<?php

use function Joiner\join;

$name = 'Ada';
$isReturning = true;

$message = join(['Hello,', $name, ['welcome back' => $isReturning]], ' ');
// 'Hello, Ada welcome back'

join(args: ['first', 'second'], separator: ' / ');
// 'first / second'
```

## Arguments

- Pass all values in the first array argument; use the optional second argument to choose the separator (default: `''`).
- Non-empty strings and integers are included as strings, including `'0'`.
- Objects implementing `__toString()` are included using their string value.
- List arrays are recursively processed; associative arrays and `stdClass` objects include keys/properties whose values pass their condition.
- Other non-string values in lists are ignored. For map conditions, non-empty strings are true; other values use PHP truthiness.

Other objects are ignored; map objects must be `stdClass`.

## CSS class names

`classnames(...$arguments)` joins values with spaces like `join()`, then emits a PHP `E_USER_WARNING` for each output token that is not a CSS `<ident>` according to [MDN](https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/Values/ident). It returns the joined string unchanged. Use `join()` when the strings are not CSS class names.

```php
use function Joiner\classnames;

classnames('button', ['button-active' => true]);
// 'button button-active'
```
