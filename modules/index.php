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
    echo "hello world this is home";
});

$routes->run();

// foreach (scandir(__DIR__) as $row => $value) {
// 	if(false === str_contains((string)$value, '.')) {
// 		require_once __DIR__ . "/{$value}/routes.php";
// 	}
// }