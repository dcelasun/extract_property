# extract_property() for PHP

This simple library provides an easy to extract a given property from an array of objects.

## Usage

```
array extract_property( array $objects [, mixed $key] [, mixed $index] )
```

Given an array of objects, `extract_property()` returns the values
from a single property of each object, identified by $key`.
Optionally, you may provide an `$index` to index the values in the returned
array by the values from the `$index` property of each object in the input array.

For example, using the following `$users` array, we tell `extract_property()` to
return an array of just the names, indexed by their record IDs.

``` php
<?php
$users = array();

$a = new stdClass;
$b = new stdClass;
$c = new stdClass;

$a->id = 1;
$a->name = 'John';
$a->surname = 'Doe';

$users[] = $a;

$b->id = 2;
$b->name = 'Jane';
$b->surname = 'Doe';

$users[] = $b;

$c->id = 3;
$c->name = 'Foo';
$c->surname = 'Bar';

$users[] = $c;

$names = extract_property($users, 'name', 'id');
```

If we call `print_r()` on `$names`, you'll see a resulting array that looks
a bit like this:

``` text
Array
(
    [1] => John
    [2] => Jane
    [3] => Foo
)
```

You could of course omit the `$index` so the resulting array looks like this:

``` text
Array
(
    [0] => John
    [1] => Jane
    [2] => Foo
)
```


## Installation

The easiest way to install this library is to use Composer and add the following
to your project's `composer.json` file:

``` javascript
{
    "require": {
        "dcelasun/extract_property": "~1.1"
    }
}
```

Then, when you run `composer install`, everything will fall magically into place,
and the `extract_property()` function will be available to your project, as long as
you are including Composer's autoloader.

_However, you do not need Composer to use this library._

This library has no dependencies and should work on older versions of PHP.
Download the code and include `src/extract_property.php` in your project, and all
should work fine.
