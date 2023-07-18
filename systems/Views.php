<?php

declare(strict_types=1);

namespace Empu;

/**
 * Empu-View Module
 * -------
 * View
 * Generate view with template engine or pure html
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;

class Views extends Core
{
    public static $global_props = [];
	public static function render(string $path, $_props = []): void
	{
        try {
            foreach ($_props as $row => $value) {
                ${$row} = $value;
            }
            self::$global_props = $_props;
            require_once __DIR__ . "/../modules/". $path .".php";
        } catch (\Throwable $th) {
            $empuError = [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ];
            require_once __DIR__ . "/../systems/errors/html/errorHandler.php";
        }
	}

    public static function loadView(string $path): void
    {
        foreach(self::$global_props as $row => $value) {
            ${$row} = $value;
        }
        require_once __DIR__ . "/../modules/". $path .".php";
    }
}