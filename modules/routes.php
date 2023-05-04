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

/* Page not found handler */
$routes->notFoundHandler(function() {
    echo "Your page is not found";
});


/* Your main routes */
$routes->get('/', function() {
    \Core\Libs::response([
        'appname' => \Core\Routes::$ENV['APP_NAME'] ?? 'Emputantular Framework',
        'version' => \Core\Routes::$ENV['APP_VERSION'] ?? '2.0.0',
    ]);
});

$routes->group('/masters', function($routes) {
    $routes->get('/users', UserController::class . '::index');
    $routes->get('/users/{$email}/{$fullname}', UserController::class . '::detail');
});

$routes->run();