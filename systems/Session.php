<?php

namespace Empu;
ob_clean();
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
	public static function get(String $name = '')
	{
		return $_SESSION[$name] ?? null;
	}

	public static function store(array $data = []): bool
	{
		foreach ($data as $row => $value) {
			$_SESSION[$row] = $value;
		}
		return true;
	}

	public static function unset(String $name = ''): void
	{
		unset($_SESSION[$name]);
	}

	public static function destroy(): void
	{
		session_unset();
		session_destroy();
	}
}