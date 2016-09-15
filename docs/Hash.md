Hash
===
This class provides shortcuts for common encryption and decryptions methods

###Hashing passwods:

Method signature
`Hash::hashPassword($password, $salt = null, $rounds = 0)`
 * $password - password to be hashed
 * $salt - salt to use with encryption, will be auto generated if not specified
 * $rounds - Commonly known as 'cost'. Number of iterations used during the encryption.


```php
    $hash = Hash::hashPassword('abc');

    // Will hash password using default algorithm (sha512) and random salt
    // This method returns Hash object containing details used in encryption
    // The result may look like this
      print(Hash::hashPassword('abc'));
      // Outputs:
      // class Ucc\Crypt\Hash (4) {
      //  private $algo =>
      //  string(6) "sha512"
      //  private $hash =>
      //  string(128) "d432fsdIduahDSAad8d8aydjhd8XCVaydndjkashdxcjh97893b322jKSHFhjksfouruiqyjhjfjkhfaufyewhxjhsd8f798GGD3rfhsdkjvgn,mznNSJMGSAggfas"
      //  private $salt =>
      //  string(64) "UD075_YJKAHns5ycuyuhew-241jhz_e782hjdsyTDY15ushzqGDsGsa&82XJsyaA"
      //  private $rounds =>
      //  integer (0)
      //  }
```

###Hashing objects (or strings):

Method signature
`Hash::hashPassword($password, $salt = null, $rounds = 0, $algo = null)`
 * $password - password to be hashed
 * $salt - salt to use with encryption, will be auto generated if not specified
 * $rounds - Commonly known as 'cost'. Number of iterations used during the encryption.
 * $algo - algorithm to use for encryption. Default sha512


```php
    $object = new \StdClass();
    $object->name = "hello worlds";

    $hash = Hash::hash($object);

    // Will hash object using default algorithm (sha512) and random salt
    // This method returns Hash object containing details used in encryption
    // The result may look like this
      print(Hash::hashPassword('abc'));
      // Outputs:
      // class Ucc\Crypt\Hash (4) {
      //  private $algo =>
      //  string(6) "sha512"
      //  private $hash =>
      //  string(128) "d432fsdIduahDSAad8d8aydjhd8XCVaydndjkashdxcjh97893b322jKSHFhjksfouruiqyjhjfjkhfaufyewhxjhsd8f798GGD3rfhsdkjvgn,mznNSJMGSAggfas"
      //  private $salt =>
      //  string(64) "UD075_YJKAHns5ycuyuhew-241jhz_e782hjdsyTDY15ushzqGDsGsa&82XJsyaA"
      //  private $rounds =>
      //  integer (0)
      //  }
```

###Generating salt

Generates random salt

Method signature
`Hash::generateSalt($length = 64, $useBase64 = true)`
 * $length - salt length
 * $useBase64 - Whether to use Base64 (default). Base64 consist of Base62 (alphanumeric chars) plus `-` hyphen and `_` underscore

```php

    $hash = Hash::generateSalt();

    // Will generates random salt using Base64 (alphanumeric chars and `-`, `_`)
    // The result may look like this
      print(Hash::generateSalt());
      // Outputs:
      //  string(64) "UD075_YJKAHns5ycuyuhew-241jhz_e782hjdsyTDY15ushzqGDsGsa&82XJsyaA"
```
