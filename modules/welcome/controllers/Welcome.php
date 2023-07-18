<?php

/**
 * Init your namespace first, !!make sure your path folder!!
 * Validate with EmpuCoreApp for prevent direct access from url
 * 
 * @var EmpuCoreApp
 * @var string title that you send to view will replace title inside <title> element automatically
 * */

namespace Modules\Welcome\Controllers;

if (!defined('EmpuCoreApp'))
	exit('You cannot access the file directly bro!');

use Empu\Controller;
use Empu\Views;

class Welcome extends Controller
{
	public function index()
	{
		$quote = "
			Many people say it’s easier to learn a language when you are young but there are advantages to learning a language when you are older.
		";
		Views::render("welcome/views/welcome", [
			'title' => 'Welcome page',
			'quote' => $quote
		]);
	}
}