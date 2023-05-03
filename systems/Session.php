<?php

namespace Core;

/**
 * Empu-Session Module
 * -------
 * Global session.
 * Stored in local storage, cached, or database
 * 
 * @version 2.0.0
*/

class Session
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