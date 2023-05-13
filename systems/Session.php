<?php

namespace Empu;
ob_clean();
session_start();

/**
 * Empu-Session Module
 * -------
 * Global session
 * Stored in local storage, cookies, or database
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\DB;

class Session extends Core
{

	public static function createSession($conn = null): void
	{
		if($conn) {
			$conn->query("
				CREATE TABLE IF NOT EXISTS empu_sessions(
					sess_name text,
					sess_value text,
					sess_code text,
					sess_created timestamp
				)
			");
		}
	}

	public static function get(string $name = ''): string
	{
		$driver = $_ENV['CONF_SESS_DRIVER'] ?? 'cache';
		if (strtolower($driver) === 'cache') {
			return $_SESSION[$name] ?? null;
		} else if(strtolower($driver) === 'database') {
			$__db = new DB();
			$__response = $__db->table('empu_sessions')
				->where('sess_name', $name)
				->first();

			$__db = null;
			return $__response ? $__response->sess_value : null;
		}
	}

	public static function store(array $data = []): bool
	{
		date_default_timezone_set('Asia/Jakarta');
		$driver = $_ENV['CONF_SESS_DRIVER'] ?? 'cache';
		$__db = strtolower($driver) === 'database' ? new DB() : null;

		foreach ($data as $row => $value) {
			if(strtolower($driver) === 'cache') {
				$_SESSION[$row] = $value;
			} else if(strtolower($driver) === 'database') {
				$__db->table('empu_sessions')->insert([
					'sess_name' => $row,
					'sess_value' => $value,
					'sess_code' => sha1($row.$value.date('ymdhis')),
					'sess_created' => date('Y-m-d H:i:s')
				]);
			}
		}
		return true;
	}

	public static function unset(string $name = ''): void
	{
		unset($_SESSION[$name]);
	}

	public static function destroy(): void
	{
		session_unset();
		session_destroy();
	}
}