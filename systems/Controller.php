<?php

declare(strict_types=1);

namespace Empu;

/**
 * Empu-Controller Module
 * -------
 * Controller
 * Base controller for all controllers in modules
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;
use Empu\DB;

class Controller extends Core
{
    public $DB;

	public function __construct()
	{
		$this->DB = new DB();
	}

	public function redirectTo($route = "/")
	{
		echo "this one should be redirect to {$route}!";
	}

	public function redirectBack()
	{
		echo "this one should redirect to last page!";
	}
}