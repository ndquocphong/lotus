<?php

/** @var Composer\Autoload\ClassLoader $autoloader */
$autoloader = require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

$moduleDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'module';
foreach (new DirectoryIterator($moduleDir) as $vendor) {
    if (!$vendor->isDir() || $vendor->isDot()) {
        continue;
    }

    foreach (new DirectoryIterator($vendor->getRealPath()) as $package) {
        if (!$vendor->isDir() || $package->isDot()) {
            continue;
        }

        $autoloader->addPsr4(
            $vendor .'\\'.$package.'\\',
            $package->getRealPath() . DIRECTORY_SEPARATOR . 'src'
        );
    }
}

