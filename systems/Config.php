<?php

declare(strict_types=1);

namespace Core;

/**
 * Empu-Config Module
 * -------
 * Load database configurations
 * 
 * @version 2.0.0
*/

class Config
{
	private $conn;

	public function psql_connect($configs = null)
	{
		// try {
		// 	$DSN = "pgsql:host={$configs->DB_HOST};port={$configs->DB_PORT};dbname={$configs->DB_NAME};";
		// 	return new PDO(
		// 		$DSN,
		// 		$configs->DB_USER,
		// 		$configs->DB_PASSWORD,
		// 		[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
		// 	);
		// } catch (PDOException $e) {
		// 	die($e->getMessage());
		// }
	}

	public function mysql_connect($configs = null)
	{
		
	}


}