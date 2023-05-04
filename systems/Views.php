<?php

declare(strict_types=1);

namespace Core;

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

use Core\Core;

class Views extends Core
{
	public static function render(string $path, $data = []): void
	{
        foreach ($data as $row => $value) {
            ${$row} = $value;
        }
        ${"content"} = $path;
		require_once __DIR__ . "/../modules/app.php";
	}
}