<?php

/**
 * Empu-ModRoutes
 * -----------
 * 
 * Read all modules declared and match with current url
 *
 * @package  Emputantular ModRoutes
 * @version  2.0.0
*/

use Core\Routes;
use Modules\Main\Controllers\UserController;

$routes = new Routes();

$routes->notFoundHandler(function() {
    \Core\Views::render("main/views/errors/404");
});

/* Main Routes */
$routes->get('/', function() {
    \Core\Libs::response([
        'appname' => \Core\Routes::$ENV['APP_NAME'] ?? 'Emputantular Framework',
        'version' => \Core\Routes::$ENV['APP_VERSION'] ?? '2.0.0',
    ]);
});

$routes->group('/masters', function($routes) {
    $routes->get('/users', UserController::class . '::index');
    $routes->get('/users/{$id}', ['Auth'], UserController::class . '::detail');
});

$routes->run();