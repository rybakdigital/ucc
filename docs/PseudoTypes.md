PseudoTypes
===
This class provides utility methods for checking pseudo types of data:

 * [filter](https://github.com/rybakdigital/ucc/blob/master/docs/PseudoTypes.md#filter)

Filter
====
Checking if value is valid filter (Note that `$requirements` are mandatory )
```php
  $filters        = array('and-id-eq-value-12');
  $requirements   = array('fields' => array('id'));
  print(PseudoTypes::checkFilter($filters, $requirements));
  // Outputs:
  // array(1) {
  // [0] =>
  // class Ucc\Filter\Criterion\Criterion (5) {
  //  private $logic =>
  //  string(3) "and"
  //  private $key =>
  //  string(2) "id"
  //  private $operand =>
  //  string(2) "eq"
  //  private $type =>
  //  string(5) "value"
  //  private $value =>
  //  string(2) "12"
  //  }
  //}
  
  // index 'fields' is required and skippind this requirement will throw `InvalidDataTypeException`
  $requirements   = array();
  print(PseudoTypes::checkFilter($filters, $requirements));
  // Throws: InvalidDataTypeException:'allowable list of fields constraint has not been specified for a filter'
```

Available requirements options (index 'fields' is required and skippind this requirement will throw `InvalidDataTypeException`):
```php
    public static $requirementsOptions = array(
        'fields' => 'List of fields allowed for a filter',          // Example: array('foo', 'bar')
    );
```
