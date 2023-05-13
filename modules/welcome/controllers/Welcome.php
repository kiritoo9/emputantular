<?php

/**
 * Init your namespace first, !!make sure your path folder!!
 * Validate with EmpuCoreApp for prevent direct access from url
 * 
 * @var EmpuCoreApp
 * */

namespace Modules\Welcome\Controllers;
if(!defined('EmpuCoreApp')) exit('You cannot access the file directly bro!');

/**
 * Load your library here
 **/

use Empu\Controller;
use Empu\Views;
use Empu\Session;

class Welcome extends Controller
{
	public function index()
	{
		$user_id = Session::get('user_id');

		$quote = "Many people say it’s easier to learn a language when you are young but there are advantages to learning a language when you are older.";
		
		Views::render("welcome/views/welcome", [
			'quote' => $quote
		]);
	}
}