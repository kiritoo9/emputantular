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

		$DB->table('mytable')
			->select('id','username')
			->where('id', '1')
			->where('username', '=', 'naruto')
			->where('deleted', null)
			->join('detail_table', 'detail_table.id_mytable', 'mytable.id', 'LEFT')
			->orderBy('mytable.created_date', 'ASC')
			->orderBy('detail_table.created_date', 'ASC')
			->limit(10)
			->offset(0)
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