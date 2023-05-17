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
use Modules\Welcome\Controllers\Heroes;

$routes = new Routes();

/**
 * Init Routes
 * -----
 * 
 * See route documentations to use Route Modules
 * */

$routes->get('/', Welcome::class . '::index');

/**
 * CRUD Example
 * -----
 * 
 * You can delete this routes after installation
 * Module used /welcome
 * */

$routes->group('/heroes', function($routes) {
    $routes->get('/', Heroes::class . '::index');
    $routes->get('/add', Heroes::class . '::add');
});

$routes->run();