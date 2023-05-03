<?php

namespace Core;

/**
 * Empu-Core Module
 * -------
 * Core framework system
 * Load app configurations
 * - Database
 * - etc.
 * 
 * @version 2.0.0
*/

use Symfony\Component\Dotenv\Dotenv;
use Core\Config;

class Core
{
	protected $app = [
		'conn' => null,
		'session' => null
	];

	private $DB;

	protected function _loadEnv()
	{
		$dotenv = new Dotenv();
		$dotenv->load(__DIR__.'/../.env');
	}

	public function init()
	{
		$this->_loadEnv();
		$this->DB = new Config();

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
			$this->app['conn'] = $this->DB->psql_connect($DB_CONFIGS);
		} elseif($use_database && $DB_CONFIGS->DB_DRIVER == 'mysql') {
			$this->app['conn'] = $this->DB->psql_connect($DB_CONFIGS);
		}

		return $this->app;
	}
}