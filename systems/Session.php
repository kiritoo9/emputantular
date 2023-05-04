<?php

namespace Empu;

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
	public static function set()
	{
		echo "get session";
	}

	public static function store()
	{
		echo "store session";
	}

	public static function delete()
	{
		echo "delete session";
	}
}