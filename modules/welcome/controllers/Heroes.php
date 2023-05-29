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
use Modules\Welcome\Business\Welcome;

class Heroes extends Controller
{
	public $welcome_business;

	public function __construct()
	{
		$this->welcome_business = new Welcome();
	}

	public function index()
	{
		/**
		 * Get data from business
		 * Read full documentations for another functions
		 * */

		$heroes = $this->welcome_business->getHeroes();
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

		$hero = $this->welcome_business->getHeroById($id);
		if(!$hero) {
			return $this->redirectTo("/heroes");
		}

		Views::render("welcome/views/heroes/edit", [
			'title' => 'Edit Heroes',
			'hero' => $hero
		]);
	}

	/**
	 * Hero Actions
	 * -------
	 * Example to handle CRUD actions
	 * 
	 * func setResponse((int)statusCode, (string)message, (array)responseData, (string)redirectUrl);
	 * Use in form action
	 * 
	 * func redirectTo((string)redirectUrl, (string)message)
	 * Use in action without form
	 */

	public function insert($request)
	{
		if($request['fullname']) {
			$this->welcome_business->insertHero([
				"id" => $this->uuidv4(),
				"fullname" => $request['fullname'],
				"strength" => $request['strength'],
				"secret_power" => $request['secret_power'],
			]);
			$this->setResponse(201, "Insert success", $request, "/heroes");
		} else {
			$this->setResponse(400, "Make sure all fields if filled!");
		}
	}

	public function update($request)
	{
		if($request['fullname']) {
			$this->welcome_business->updateHero($request['id'], [
                "fullname" => $request['fullname'],
                "strength" => $request['strength'],
                "secret_power" => $request['secret_power'],
            ]);
			$this->setResponse(201, "Update success", $request, "/heroes");
		} else {
			$this->setResponse(400, "Make sure all fields if filled!");
		}
	}

	public function delete($request)
	{
		if(isset($request['id'])) {
			$this->welcome_business->deleteHero($request['id']);
		}
		$this->redirectTo("/heroes", "Delete success");
	}
}