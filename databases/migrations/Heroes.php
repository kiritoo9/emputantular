<?php

namespace Migrations;
use Empu\Model;

class Heroes extends Model
{
	public function up(): void
	{
		$this->schema('heroes', function($table) {
			$table->uuid('id')
				->primary_key();

			$table->varchar('fullname')
				->length(100)
				->comment('default fullname')
				->nullable(true);

			$table->numeric('strength')
				->length(10)
				->comment('hero strength!')
				->nullable(true);

			$table->text('secret_power')
				->comment('e.g: hero can see future if he touch someone in head')
				->nullable(true);
		});
	}

	public function down(): void
	{
		$this->schema_drop('heroes');
	}

}