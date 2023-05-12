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

    function __shutdownHandle() {
        $error = error_get_last();
        if ($error === null)
            return;

        $exception = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
        Logs::empuErrHandler($exception);
    }

    function __warningHandler($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }

    register_shutdown_function("__shutdownHandle");
    set_error_handler("__warningHandler", E_WARNING);
    error_reporting(0);

    /**
     * Load Core
     * Module routes are included
    */

    $app = new Core();
    $app->init();
    require __DIR__ . '/modules/routes.php';

} catch(Throwable $empuErrHandler) {
    Logs::empuErrHandler($empuErrHandler);
}