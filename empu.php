<?php

class Manage
{
	protected int $fm_choosed = 0;
	protected $menu_list = [
		'Module',
		'Controller',
		'Model',
		'Migration',
		'Seed'
	];

	public function help()
	{
		echo "this is helper";
	}

	public function run()
	{
		$line = "------------------------\n";
		$str_line = $line."--- EMPUTANTULAR CLI ---\n".$line."\nversion: 2.0.0\nauthor: kiritoo9\n\nwhich one do you want to generate:\n";
		foreach ($this->menu_list as $row => $value) {
			$row++;
			$str_line .= "{$row}. {$value}\n";
		}
		echo(trim($str_line));

		$user_input = (int)readline("\n\ntype something bro: ");
		if($user_input > 0 && $user_input <= count($this->menu_list)) {
			try {
				switch ($user_input) {
					case 1:
						$this->handleModule();
						break;
					case 2:
						$this->handleController();
						break;
					case 3:
						$this->handleModel();
						break;
					case 4:
						$this->handleMigration();
						break;
					case 5:
						$this->handleSeed();
						break;
				}
			} catch(Throwable $e) {
				exit("\n".$e);
			}
		} else {
			exit("\nResponse: awkwkwk bodoh kah????!!");
		}
	}

	/**
	 * Handlers
	 * ------
	 * 
	 * Generator handle
	 * Make sure your permission folder is 0777
	 * */

	protected function handleMigration()
	{
		exit("\n".shell_exec('php commands/migrations.php --filename= --type=up'));
	}

}

/**
 * Run Apps
 * -----
 * 
 * Check parameters
 * */

$params = getopt('params', ["help:"]);
$help = isset($params['help']) ? strtolower($params['help']) : null;

$app = new Manage();
if($help) {
	$app->help();
} else {
	$app->run();
}