<?php

namespace Modules\Main\Controllers;

use Empu\Controller;
use Empu\Views;

class UserController extends Controller
{
	public function index()
	{
		Views::render("main/views/dashboard", [
			'data' => $this->DB->table('mytable')->get()
		]);
	}

	public function detail($request)
	{
		Views::render("main/views/users/users", [
			'id' => $request['id']
		]);
	}
}