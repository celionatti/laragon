<?php

/**
 * Laragon Main Entry (Index)
 */


require __DIR__ . '/../vendor/autoload.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env');

require dirname(__DIR__) . '/Core/Function.php';

\Core\Application::init();