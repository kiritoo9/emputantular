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

use Empu\Routes;
use Empu\Libs;
use Empu\Views;
use Modules\Main\Controllers\UserController;

$routes = new Routes();

$routes->notFoundHandler(function() {
    Views::render("main/views/errors/404");
});

/* Main Routes */
$routes->get('/', function() {
    Libs::response([
        'appname' => Routes::$ENV['APP_NAME'] ?? 'Emputantular Framework',
        'version' => Routes::$ENV['APP_VERSION'] ?? '2.0.0',
    ]);
});

$routes->group('/masters', function($routes) {
    $routes->get('/users', UserController::class . '::index');
    $routes->get('/users/{$id}', ['Auth::manager'], UserController::class . '::detail');
    
});

$routes->run();