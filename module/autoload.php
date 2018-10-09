<?php
define('ROOT_DIR', dirname(__DIR__));
define('MODULE_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'module');
define('VENDOR_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'vendor');
define('PUBLIC_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'public');

/** @var \Composer\Autoload\ClassLoader $autoloader */
$autoloader = require_once VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php';

$autoloader->addPsr4(
     'Lotus\\Core\\',
    [
        MODULE_DIR . DIRECTORY_SEPARATOR . 'Lotus' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'src',
        MODULE_DIR . DIRECTORY_SEPARATOR . 'Lotus' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'var' . DIRECTORY_SEPARATOR . 'code',
    ]
);

return $autoloader;