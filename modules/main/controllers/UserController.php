<?php

namespace Modules\Main\Controllers;

use Core\Controller;

class UserController extends Controller
{
	public function index()
	{
		\Core\Views::render("main/views/main_view");
	}

	public function detail($request)
	{
		\Core\Views::render("main/views/main_view", [
			'id' => $request['id']
		]);
	}
}