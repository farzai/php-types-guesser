# php-types-guesser
This package will helpful cast your value or guess your value type

### Installation
```
composer require farzai/php-types-guesser
```

### Example
```php
use Farzai\Guesser\TypeGuesser

// --- String Type
$guesser = TypeGuesser::of("This is message");
echo $guesser; // Print "This is message"
// is_string($guesser->getValue()) === true


// --- Array Type
$guesser = TypeGuesser::of([1, 2]);
echo $guesser; // Print "[1, 2]"
// $guesser->isArray() === true
// $guesser->isJson() === false


// ---- JSON Type
$guesser = TypeGuesser::of("[1, 2]");
echo $guesser; // Print "[1, 2]"
// $guesser->isArray() === true
// $guesser->isJson() === true
```
