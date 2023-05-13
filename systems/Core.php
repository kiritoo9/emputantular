<?php 

namespace Empu;

/**
 * Empu-Core Module
 * -------
 * Core framework system
 * Load app configurations
 * - Database
 * - etc.
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Symfony\Component\Dotenv\Dotenv;
use Empu\Config;
use Empu\Session;

define("EmpuCoreApp", TRUE);

class Core
{

	public $database_connection;

	protected function __loadEnv()
	{
		$dotenv = new Dotenv();
		$dotenv->load(__DIR__.'/../.env');
	}

	public function init(): void
	{
		$this->__loadEnv();

		$DB = new Config();

		$DB_CONFIGS = (object)[
			"DB_HOST" => $_ENV['DB_HOST'] ?? null,
			"DB_USER" => $_ENV['DB_USER'] ?? null,
			"DB_NAME" => $_ENV['DB_NAME'] ?? null,
			"DB_PASS" => $_ENV['DB_PASS'] ?? null,
			"DB_PORT" => $_ENV['DB_PORT'] ?? null,
			"DB_DRIVER" => strtolower($_ENV['DB_DRIVER']) ?? null,
		];

		$use_database = false;
		if (
			$DB_CONFIGS->DB_HOST && $DB_CONFIGS->DB_NAME 
			&& $DB_CONFIGS->DB_PASS && $DB_CONFIGS->DB_PORT 
			&& $DB_CONFIGS->DB_DRIVER && $DB_CONFIGS->DB_USER 
		) $use_database = true;

		if($use_database && $DB_CONFIGS->DB_DRIVER == 'postgre') {
			$this->database_connection = $DB->psql_connect($DB_CONFIGS);
		} elseif($use_database && $DB_CONFIGS->DB_DRIVER == 'mysql') {
			$this->database_connection = $DB->psql_connect($DB_CONFIGS);
		}

		if($this->database_connection) {
			$SESS_DRIVER = $_ENV['CONF_SESS_DRIVER'] ?? null;
			if($SESS_DRIVER && strtolower($SESS_DRIVER) === 'database') {
				Session::createSession($this->database_connection);
			}
		}
	}

	protected static function debug($data, $withDie = false)
	{
		echo "<pre>";
		print_r($data);
		if($withDie) die;
	}
}