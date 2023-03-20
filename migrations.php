<?php

/**
 * Laragon Migrations File.
 */


require __DIR__ . '/vendor/autoload.php';

$dotenv = new \Symfony\Component\Dotenv\Dotenv();
$dotenv->load(__DIR__ . DIRECTORY_SEPARATOR . '.env');

require __DIR__ . '/Core/Function.php';


$migration = new \Core\Database\Migration();

$migration->applyMigrations();