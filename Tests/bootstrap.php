<?php

/**
* Ucc test bootstrap.
*
* @author Kris Rybak kris@krisrybak.com>
* @package ucc
*/

use Ucc\Autoloader;

//Set the include path to the classes directory
set_include_path(get_include_path() .
    PATH_SEPARATOR . '/home/sites/ucc'
);

// Load local classes
require_once 'Ucc/Autoloader.php';

Autoloader::enable();
