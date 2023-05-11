<?php

namespace Empu;

/**
 * Empu-DB Module
 * -------
 * Query Builder
 * translate your query to raw
 * connection needs Module Config
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;

class DB extends Core
{

    public string $global_table;
    public array $global_select;
    public array $global_where;
    public array $global_join;
    public array $global_order;

    public function table($tablename)
    {
        $this->global_table = $tablename;
        return $this;
    }

	public function select(...$params)
	{
	   print_r($params);
       return $this;
	}

    public function where(...$params)
    {
        print_r($params);
        return $this;
    }

    public function get()
    {
        // EXECUTE QUERY
    }

}