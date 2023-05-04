<?php

namespace Modules\Main\Controllers;

use Empu\Controller;
use Empu\Views;

class UserController extends Controller
{
	public function index()
	{
		Views::render("main/views/main_view");
	}

	public function detail($request)
	{
		Views::render("main/views/main_view", [
			'id' => $request['id']
		]);
	}
}