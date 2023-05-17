<?php

/**
 * Init your namespace first, !!make sure your path folder!!
 * Validate with EmpuCoreApp for prevent direct access from url
 * ClassName and Filename must "SAME"!
 * 
 * @var table_name -> defined your table target
 * @var primary_key -> primary key of table
 * 
 * */

namespace Modules\Welcome\Models;
if(!defined('EmpuCoreApp')) exit('You cannot access the file directly bro!');

use Empu\Model;

class Heroes extends Model
{
	protected string $table_name = '';
	protected string $primary_key = '';
}