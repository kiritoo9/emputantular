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
use Empu\Session;

class Views extends Core
{
	public static function render(string $path, $data = []): void
	{
        foreach ($data as $row => $value) {
            ${$row} = $value;
        }
        ${"content"} = $path;
        $empuui = $_COOKIE['empuui'] ?? null;

		require_once __DIR__ . "/../modules/". ($empuui ? $path : "app") .".php";
        if($empuui) {
            unset($_COOKIE['empuui']);
            setcookie('empuui', '', time() - 3600, '/');
        }
	}
}