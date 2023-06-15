# Overview

This bundle offers some common utility that is missing from PHP/Symfony.

## RandomString

This utility offers a static function to generate a random string, with the
ability to pass in a callback function to validate the uniqueness of the string.

```php
use OHMedia\UtilityBundle\Util\RandomString;

$userToken = RandomString::get($length, function(string $str) use ($userRepository) {
    return !$userRepository->countByToken($str);
});
```

## Uniq ID Service

This basic service gives back a guaranteed unique string per execution lifecycle.

Its main intent is for generating strings for HTML elements in templates.

You can generate a string in PHP:

```php
use OHMedia\UtilityBundle\Service\Uniq;

public function index(Uniq $uniq)
{
    $id = Uniq::get(20);
}
```

Or in a Twig template:

```twig
{% set id = uniq(20) %}
```

## Other Twig Functions

There is a filter for shuffling an array:

```twig
{% set shuffled = my_array|shuffle %}
```
