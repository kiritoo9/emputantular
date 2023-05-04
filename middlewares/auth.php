<?php

/**
 * Empu-Middleware
 * -----------
 * 
 * This file will execute before page rendered
 * Only function init() will executed
 * $request to get headers
 * return false to allow validations, otherwise it will return 501
 * 
 * @package  Emputantular Middlewares
 * @version  2.0.0
 * @var bool stop
 * @var array request
*/

namespace Middlewares;

class Auth
{
	public function init($request): bool
	{
		$unauthroized = false;
		if(1 == 2) {
			$unauthroized = true;
		}

		return $unauthroized;
	}
}