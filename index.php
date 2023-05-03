<?php

/**
 * Emputantular - PHP-JS Simple Framework
 *
 * @package  Emputantular Main
 * @author   KST Teams <aloha@kst.dev>
*/

require __DIR__ . '/vendor/autoload.php';

use Core\Core;

$app = new Core();
$app->init();

/**
 * Load Routes
*/

require __DIR__ . '/modules/index.php';