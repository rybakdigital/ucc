#Criterion

This class allows to represent filter criteria

## Properties and methods
Criterion has following private properties: `logic`, `key`, `operand`, `type` and `value`. All are accessible by their gettersand setters methods. In addition to standrad getters set of shortcut aliases named exactly the same as properties are available: For example: `getLogic()` has an alias of `logic()` that returns value of `logic` property.

Basic usage:
```php
use Ucc\Data\Filter\Criterion\Criterion;

$criterion = new Criterion();

// Setting logic
$criterion->setLogic('eq');

// Getting logic
$criterion->getLogic();
// or simply
$criterion->logic();

// Outputs `eq`
```
