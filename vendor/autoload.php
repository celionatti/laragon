<?php 

require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/dotenv/Dotenv.php');
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/dotenv/Exception/ExceptionInterface.php');
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/dotenv/Exception/FormatException.php');
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/dotenv/Exception/FormatExceptionContext.php');
require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/dotenv/Exception/PathException.php');

spl_autoload_register(function($className){
    $parts = explode('\\', $className);
    $class = end($parts);
    array_pop($parts);
    $path = strtolower(implode(DIRECTORY_SEPARATOR, $parts));
    $path = dirname(__DIR__) . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($path))
    {
        require($path);
    }
});