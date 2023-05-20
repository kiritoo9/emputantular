<?php

declare(strict_types=1);

namespace Empu;

/**
 * Empu-Controller Module
 * -------
 * Controller
 * Base controller for all controllers in modules
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;
use Empu\DB;

class Controller extends Core
{
    public $DB;

	public function __construct()
	{
		$this->DB = new DB();
	}

	/**
	 * setResponse($code, $data, $redirectUrl);
	 * 
	 * $code int 200|201|400|403|404|500
	 * $message sting
	 * $data array
	 * $redirectUrl string --> if you are not set redirectUrl, page won't change to anywhere
	 * 
	 */
	public function setResponse(int $code = 200, string $message = "", array $data = [], $redirectUrl = null)
	{
		$status = "OK";
		switch($code) {
			case 200:
				$status = "OK";
			break;
			case 201:
				$status = "Created";
			break;
			case 400:
				$status = "Bad Request";
			break;
			case 401:
				$status = "Unauthorized";
			break;
			case 403:
				$status = "Access Forbiden";
			break;
			case 500:
				$status = "Internal Server Error";
			break;
		}

		header("HTTP/1.0 {$code} {$status}");
		if($redirectUrl) $data['__empuRedirectUrl'] = $redirectUrl;
		$data['__empuResponseMessage'] = $message;
		echo json_encode($data);
		return exit();
	}

	public function redirectTo($redirectUrl = null, string $message = "")
	{
		if($redirectUrl) {
			require_once __DIR__ . "/web/redirectHandler.php";
		}
		return exit();
	}

	public function uuidv4()
	{
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0fff ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
		);
	}
}