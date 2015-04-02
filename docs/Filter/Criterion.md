#Criterion

This class allows to represent filter criteria.

## Definitions

`logic` - Represents logic part of the criterion. Decides whether to apply "AND" (Intersection) or "OR" (Union) on subsets.

`key` - Name of the key to apply Criterion to.

`operand` - String representation of logic operands.

`type` - Criterion type. This can be either "field" or "value" (more common). Tells whether to use value of a given field described by the key for comparison or another field.

`value` - Either value or the name of the filed to compare.

Example 1:

{logic}-{key}-{operand}-{type}-{value} : "AND-make-eq-value-Audi"
This tells Criterion to look for elemnts where `make` is equal (`eq`) to the value of `Audi`. `AND` means that this is an intersection of subsets (must match all conditions: AND Criterion1 AND Criterion2 AND Criterion3, ..., etc.)

Example 2:

{logic}-{key}-{operand}-{type}-{value} : "OR-make-eq-value-Audi"
This tells Criterion to look for elemnts where `make` is equal (`eq`) to the value of `Audi`. `OR` means that this is an union of subsets (may match one or more of the conditions: OR Criterion1 OR Criterion2 OR Criterion3, ..., etc.)

Example 3:

{logic}-{key}-{operand}-{type}-{value} : "AND-town-eq-field-city"
This tells Criterion to look for elemnts where `town` is equal (`eq`) to the value of another property: `city`. In other words town and city must be equal. `OR` means that this is an union of subsets (may match one or more of the conditions: OR Criterion1 OR Criterion2 OR Criterion3, ..., etc.)

## Properties and methods
Criterion has following private properties: `logic`, `key`, `operand`, `type` and `value`. All are accessible by their gettersand setters methods. In addition to standrad getters set of shortcut aliases are available: `logic()`, `key()`, `op()`, `type()` and `value()`. For example: `getLogic()` has an alias of `logic()` that returns value of `logic` property.

## Operands
    `bool`      - Boolean comparison, e.g. true or false.
    `eq`        - Equals comparison (case sensitive).
    `eqi`       - Equals comparison (case insensitive).
    `ne`        - Not equals comparison (case sensitive).
    `nei`       - Not equals comparison (case insensitive).
    `lt`        - Less than comparison.
    `gt`        - Greater than comparison.
    `ge`        - Greater than or equal to comparison.
    `le`        - Less than or equal to comparison.
    `inc`       - Includes (case sensitive).
    `inci`      - Includes (case insensitive).
    `ninc`      - Not includes (case sensitive).
    `ninci`     - Not includes (case insensitive).
    `re`        - Regular expression.
    `begins`    - Begins (case sensitive).
    `beginsi`   - Begins (case insensitive).
    `in`        - Comma delimited list of values to match (case sensitive).
    `ini`       - Comma delimited list of values to match (case insensitive).
    `nin`       - Comma delimited list of values to not match (case sensitive).
    `nini`      - Comma delimited list of values to not match (case insensitive).

##Basic usage
```php
use Ucc\Data\Filter\Criterion\Criterion;

$criterion = new Criterion();

// Setting logic
$criterion->setLogic('and');

// Getting logic
$criterion->getLogic();
// or simply
$criterion->logic();

// Outputs `AND`

// Setting operand
$criterion->setOperand('eq');

// Getting operand
$criterion->getOperand();
// or simply
$criterion->op();

// Outputs `eq`
```
