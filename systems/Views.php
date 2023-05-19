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
use Empu\Logs;

class Views extends Core
{
	public static function render(string $path, $data = []): void
	{
        $__setTitle = null;
        foreach ($data as $row => $value) {
            ${$row} = $value;
            if(strtolower($row) === 'title') $__setTitle = $value;
        }
        $__empuContent = $path;
        $empuui = $_COOKIE['empuui'] ?? null;

        /**
         * Handle file not exists when user try to open view
         * ------
         * Remove empuui cache
         * recall app.php to trigger try execption
         */

        // $resetEmpuui = false;
        // if(!file_exists(__DIR__ . "/../modules/{$path}.php")) {
        //     $empuui = null;
        //     $resetEmpuui = true;
        // }
        
        require_once __DIR__ . "/../modules/". ($empuui ? $path : "app") .".php";
        
        /**
         * Reset Empuui Cookies
         * Update activeTitle
         * */

        if($empuui) {
            unset($_COOKIE['empuui']);
            setcookie('empuui', '', -1, '/');
        }
        if(isset($_COOKIE['activeTitle'])) {
            unset($_COOKIE['activeTitle']);
            setcookie('activeTitle', $__setTitle, -1, '/');
        } else {
            setcookie('activeTitle', $__setTitle);
        }
	}
}