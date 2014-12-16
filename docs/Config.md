Config
===
This class provides utility methods for reading and storing configuration.

Storing and reading config examples:
```php
    $config = new Ucc\Config\Config(array('foo' => 'bar')); // Creates new config and stors `foo` parameter
    
    // Check for `foo` parameter exists
    
    print($config->hasParameter('foo'));
    // Outputs true (boolean)

    print($config->hasParameter('moo'));
    // Outputs false (boolean)
    
    // Get parameter by name

    print($config->getParameter('foo'));
    // Outputs "bar" (string)
    
    // Setting parameter
    $config->setParameter('moo', 'car'); // Sets `moo` parameter to "car"
```
