<?php

/** @var $router */

use controllers\SiteController;

$router->get('/', [SiteController::class, 'index']);

$router->get('/users', 'controllers/users.php');