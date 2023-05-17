<?php

/**
 * Empu-Migrations
 * ------
 * 
 * You will be able to migrate your database with call this file
 * But you must define migration file inside databases/migrations/
 * 
 * Run migration with two options:
 * - All files "php commands/migrations.php"
 * - Specific files "php commands/migrations.php --filename=Heroes" which means you only run migration file with name "Heroes"
 * - using --type=up for create table or --type=down for drop table
 *
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
 * 
 * */

require __DIR__ . './../vendor/autoload.php';

class EmpuMigration
{
	protected $fileTarget,$migrateType;

	public function __construct($target = null, $type = 'up')
	{
		$this->fileTarget = $target;
		$this->migrateType = $type;
	}

	public function main()
	{
		if($this->fileTarget) {
			$this->__handler($this->fileTarget, $this->migrateType);
		} else {
			$path = './databases/migrations/';
			$files = array_diff(scandir($path), array('.', '..'));
			foreach ($files as $f) {
				$_f = explode(".", $f);
				$this->__handler(array_shift($_f), $this->migrateType);
			}
		}
	}

	protected function __handler(string $fileTarget, string $migrateType): void
	{
		$__cls = "\Migrations\\{$fileTarget}";
		$obj = new $__cls();
		$mtype = $migrateType;
		$obj->$mtype();
	}
}

$params = getopt('params', ["filename:", "type:"]);
$filename = isset($params['filename']) ? strtolower($params['filename']) : null;
$type = isset($params['type']) ? strtolower($params['type']) : 'up';

/**
 * Action
 * -----
 * 
 * Code below will run when user input in terminal
 * */

$em = new EmpuMigration($filename, $type);
try {
	$em->main();
} catch(Throwable $e) {
	exit($e);
}