<?php

namespace Seeders;
use Empu\Model;

class Heroes extends Model 
{
	public function up(): void
	{
		$data = [];

		/**
		 * You can seed multiple data(s) with array
		 * */

		$data[] = [
			'id' => '16cd9b1e-d947-46b3-ae3a-2a1207a504b1',
			'fullname' => 'Spiderman',
			'strength' => 70,
			'secret_power' => 'He can walk on the wall'
		];

		$data[] = [
			'id' => '3b9f2265-4cbd-45ec-a45a-f5479e5e1a28',
			'fullname' => 'Superman',
			'strength' => 100,
			'secret_power' => 'idk he is too strong'
		];

		$this->seed('heroes', $data);
	}
}