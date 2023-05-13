<?php if(!defined('EmpuCoreApp')) exit('You cannot access the file directly bro!');

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
use Modules\Welcome\Controllers\Welcome;

$routes = new Routes();

$routes->notFoundHandler(function() {
    Views::render("welcome/views/errors/404");
});

/* Main Routes */
$routes->get('/', function() {
    Libs::response([
        'appname' => Routes::$ENV['APP_NAME'] ?? 'Emputantular Framework',
        'version' => Routes::$ENV['APP_VERSION'] ?? '2.0.0',
    ]);
});

$routes->group('/module', function($routes) {
    $routes->get('/welcome', Welcome::class . '::index');
    $routes->get('/welcome/{$id}', ['Auth::manager'], Welcome::class . '::detail');
    
});

$routes->run();