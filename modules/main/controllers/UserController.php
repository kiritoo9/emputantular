<?php

namespace Modules\Main\Controllers;

use Core\Controller;

class UserController extends Controller
{
	public function index()
	{
		echo "this is controller user";
	}

	public function detail($request)
	{
		$this->debug($request);
	}
}