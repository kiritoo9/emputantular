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

		echo "<pre>";
		$DB->table('mytable')
			->select('id','data')
			->where('id', 'myid')
			->get();
		
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