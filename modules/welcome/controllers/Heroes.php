<?php

/**
 * Init your namespace first, !!make sure your path folder!!
 * Validate with EmpuCoreApp for prevent direct access from url
 * 
 * @var EmpuCoreApp
 * @var string title that you send to view will replace title inside <title> element automatically
 * */

namespace Modules\Welcome\Controllers;
if(!defined('EmpuCoreApp')) exit('You cannot access the file directly bro!');

use Empu\Controller;
use Empu\Views;

class Heroes extends Controller
{
	public function index()
	{
		/**
		 * Query Builder example for GET data
		 * Read full documentations for another functions
		 * */
		$heroes = $this->DB->table('heroes')->get();

		Views::render("welcome/views/heroes/list", [
			'title' => 'List Heroes',
			'heroes' => $heroes
		]);
	}

	public function add()
	{
		Views::render("welcome/views/heroes/add", [
			'title' => 'Add Heroes',
		]);
	}

	public function edit($request)
	{
		$id = $request['id'] ?? null;

		$hero = $this->DB->table('heroes')->where('id', $id)->first();
		if($hero) {
			print_r($hero);
			return;
		} else {
			return $this->redirectTo("/heroes");
		}

		Views::render("welcome/views/heroes/edit", [
			'title' => 'Edit Heroes'
		]);
	}
}