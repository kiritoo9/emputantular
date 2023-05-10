<?php

namespace Empu;
session_start();

/**
 * Empu-Session Module
 * -------
 * Global session
 * Stored in local storage, cookies, or database
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

class Session extends Core
{
	public static function get($name = '')
	{
		return $_SESSION[$name] ?? null;
	}

	public static function store($data = [])
	{
		foreach ($data as $row => $value) {
			$_SESSION[$row] = $value;
		}
		return true;
	}

	public static function delete()
	{
		echo "delete session";
	}
}