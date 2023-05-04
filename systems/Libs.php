<?php

namespace Empu;

/**
 * Empu-Libs Module
 * -------
 * Global libraries
 * Bunch of default libraries, you can use everything you want
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;

class Libs extends Core
{

	public static function response(array $res = []): void
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($res);
		return;
	}

}