<?php

require_once __DIR__ . '/../../systems/Routes.php';

$routes = new Core\Routes\Routes();

print($routes->get());