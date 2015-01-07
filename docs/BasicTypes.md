BasicTypes
===
This class provides utility methods for checking basic types of data:

 * integer
 * string

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
    'values' => array(1,3,5,7,9);
  );

  print(BasicTypes::checkInteger(3, requirements));
  // Outputs: 3(int)
  print(BasicTypes::checkInteger(4, requirements));
  // Throws: InvalidDataValueException:'value must be one of: 1, 3, 5, 7, 9'
```
