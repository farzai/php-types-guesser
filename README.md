# php-types-guesser
This package will helpful cast your value or guess your value type

### Installation
```
composer require farzai/php-types-guesser
```

### Example

##### String type
```php
use Farzai\Guesser\TypeGuesser;

$guesser = TypeGuesser::of("This is message");

// Print "This is message"
echo $guesser;

$guesser->isString() === true;
```

##### Array type
```php
use Farzai\Guesser\TypeGuesser;

$guesser = TypeGuesser::of([1, 2]);

 // Print "[1, 2]"
echo $guesser;

$guesser->isArray() === true;
$guesser->isJson() === false;
```

##### JSON Type
```php
use Farzai\Guesser\TypeGuesser;

$guesser = TypeGuesser::of("[1, 2]");

echo $guesser; // Print "[1, 2]"

$guesser->isArray() === true;
$guesser->isJson() === true;
$guesser->isString() === true;
```


##### Boolean Type
```php
use Farzai\Guesser\TypeGuesser;

// Try to enter string value
$guesser = TypeGuesser::of("true");
$guesser->isBoolean() === true;
$guesser->getValue() === true;

// Boolean type
$guesser = TypeGuesser::of(true);
$guesser->isBoolean() === true;
$guesser->getValue() === true;
```

##### Numeric Type
```php
use Farzai\Guesser\TypeGuesser;

$guesser = TypeGuesser::of("1");
$guesser->isNumeric() === true;
$guesser->isInteger() === true;
$guesser->isFloat() === false;
$guesser->getValue() === 1;


$guesser = TypeGuesser::of(1.2);
$guesser->isNumeric() === true;
$guesser->isInteger() === false;
$guesser->isFloat() === true;
$guesser->getValue() === 1.2;


$guesser = TypeGuesser::of("2.1");
$guesser->isNumeric() === true;
$guesser->isInteger() === false;
$guesser->isFloat() === true;
$guesser->getValue() === 2.1;
```
