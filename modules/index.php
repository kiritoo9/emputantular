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

$routes = new Routes();

$routes->get('/', function() {
    \Core\Libs::response([
        'appname' => $routes->ENV['APP_NAME'] ?? 'Emputantular Framework',
        'version' => $routes->ENV['APP_VERSION'] ?? '2.0.0',
    ]);
});

$routes->group('/main', function($routes) {
    $routes->get('/about', function() {
        echo "Hellow this is world";
    });
});

$routes->run();