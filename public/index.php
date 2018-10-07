<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'module' . DIRECTORY_SEPARATOR .'autoload.php';

$application = new \Lotus\Core\Application();
$application->run();
