<?php

/**
 * Empu-Seeders
 * ------
 * 
 * You will be able to seed data(s) to your defined table
 * But you must define migration file inside databases/seeders/
 * 
 * Run seeders with two options:
 * - All files "php commands/seeders.php"
 * - Specific files "php commands/seeders.php --filename=Heroes" which means you only run seeders file with name "Heroes"
 *
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
 * 
 * */

require __DIR__ . './../vendor/autoload.php';

class EmpuSeeder
{
	protected $fileTarget;

	public function __construct($target = null)
	{
		$this->fileTarget = $target;
	}

	public function main()
	{
		if($this->fileTarget) {
			$this->__handler($this->fileTarget);
		} else {
			$path = './databases/seeders/';
			$files = array_diff(scandir($path), array('.', '..'));
			foreach ($files as $f) {
				$_f = explode(".", $f);
				$this->__handler(array_shift($_f));
			}
		}
	}

	protected function __handler(string $fileTarget): void
	{
		$__cls = "\Seeders\\{$fileTarget}";
		$obj = new $__cls();
		$obj->up();
	}
}

$params = getopt('params', ["filename:"]);
$filename = isset($params['filename']) ? strtolower($params['filename']) : null;

/**
 * Action
 * -----
 * 
 * Code below will run when user input in terminal
 * */

$em = new EmpuSeeder($filename);
try {
	$em->main();
} catch(Throwable $e) {
	exit($e);
}