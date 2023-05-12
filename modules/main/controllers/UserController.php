<?php

namespace Modules\Main\Controllers;

use Empu\Controller;
use Empu\Views;
use Empu\DB;

class UserController extends Controller
{
	public function index()
	{
		$DB = new DB();

		$data = $DB->table('mytable')->get();

		echo "<pre>";
		print_r($data);
		die;
		
		Views::render("main/views/dashboard");
	}

	public function detail($request)
	{
		Views::render("main/views/users/users", [
			'id' => $request['id']
		]);
	}
}