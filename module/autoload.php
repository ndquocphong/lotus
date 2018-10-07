<?php
define('ROOT_DIR', dirname(__DIR__));
define('MODULE_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'module');
define('VENDOR_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'vendor');
define('PUBLIC_DIR', ROOT_DIR . DIRECTORY_SEPARATOR . 'public');

/** @var \Composer\Autoload\ClassLoader $autoloader */
$autoloader = require_once VENDOR_DIR . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * TODO: so need improve to only autoload enabled modules
 */

foreach (new \DirectoryIterator(MODULE_DIR) as $vendor) {
    if (!$vendor->isDir() || $vendor->isDot()) {
        continue;
    }

    foreach (new \DirectoryIterator($vendor->getRealPath()) as $package) {
        if (!$vendor->isDir() || $package->isDot()) {
            continue;
        }

        $autoloader->addPsr4(
            $vendor .'\\'.$package.'\\',
            $package->getRealPath() . DIRECTORY_SEPARATOR . 'src'
        );
    }
}