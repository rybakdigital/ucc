BasicTypes
===
This class provides utility methods for checking basic types of data:

 * [integer](https://github.com/rybakdigital/ucc/blob/master/docs/BasicTypes.md#integer)
 * [string](https://github.com/rybakdigital/ucc/blob/master/docs/BasicTypes.md#string)

Integer
====
Checking if value is integer
```php
  print(BasicTypes::checkInteger(3));
  // Outputs: 3(int)
  
  // Method also converts numerical values into integers
  print(BasicTypes::checkInteger("4"));
  // Outputs: 4(int)
```
Checking if value is integer with requirements
```php
  $requirements = array(
    'min' => 2,
    'max' => 5,
  );

  print(BasicTypes::checkInteger(3, requirements));
  // Outputs: 3(int)
  print(BasicTypes::checkInteger(7, requirements));
  // Throws: InvalidDataValueException:'value must be less than or equal to 5'
  
  // Specyfic values only
  $requirements = array(
    'values' => array(1,3,5,7,9)
  );

  print(BasicTypes::checkInteger(3, requirements));
  // Outputs: 3(int)
  print(BasicTypes::checkInteger(4, requirements));
  // Throws: InvalidDataValueException:'value must be one of: 1, 3, 5, 7, 9'

  // Odd number
  $requirements = array(
    'odd' => true
  );

  print(BasicTypes::checkInteger(3, requirements));
  // Outputs: 3(int)
  print(BasicTypes::checkInteger(4, requirements));
  // Throws: InvalidDataValueException:'value must be an odd number'
```

Available requirements options:
```php
    public static $requirementsOptions = array(
        'min'       => 'Minimum allowable value',
        'max'       => 'Maximum allowable value',
        'values'    => 'List of allowable values',
        'odd'       => 'Must be an odd number',
        'even'      => 'Must be an even number',
    );
```

String
====
Checking if value is string
```php
  print(BasicTypes::checkString('foo'));
  // Outputs: 'foo'

  print(BasicTypes::checkString(array('foo')));
  // Throws: InvalidDataTypeException: 'value must be a string'
```
Checking if value is string with requirements
```php
  $requirements = array(
    'min' => 2,
    'max' => 5,
  );

  print(BasicTypes::checkString('foo', requirements));
  // Outputs: 'foo'
  print(BasicTypes::checkString('foobar', requirements));
  // Throws: InvalidDataValueException:'value length is outside of allowed range (2 to 5)'
  
  // Specyfic values only
  $requirements = array(
    'values' => array('foo', 'bar'),
  );

  print(BasicTypes::checkString('foo', requirements));
  // Outputs: 'foo'
  print(BasicTypes::checkString('loo', requirements));
  // Throws: InvalidDataValueException:'value must be one of: foo, bar'
```
Available requirements options:
```php
  public static $requirementsOptions = array(
      'min'       => 'Minimum length',
      'max'       => 'Maximum length',
      'values'    => 'List of allowable values',
  );
```
