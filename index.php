<?php

/**
 * Emputantular - PHP-JS Simple Framework
 *
 * @package  Emputantular Main
 * @author   KST Teams <aloha@kst.dev>
*/
use Empu\Core;
use Empu\Logs;

require __DIR__ . '/vendor/autoload.php';

try {

    $app = new Core();
    $app->init();

    /**
     * Load Routes
    */
    require __DIR__ . '/modules/routes.php';

} catch(Throwable $empuErrHandler) {
    Logs::empuErrHandler($empuErrHandler);
}