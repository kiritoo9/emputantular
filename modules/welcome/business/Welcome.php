<?php

/**
 * Init your namespace first, !!make sure your path folder!!
 * Validate with EmpuCoreApp for prevent direct access from url
 * 
 * @var EmpuCoreApp
 * */

namespace Modules\Welcome\Business;
if(!defined('EmpuCoreApp')) exit('You cannot access the file directly bro!');

use Empu\Model;

class Welcome extends Model {

    public function getHeroes()
    {
        return $this->connection->table('heroes')
			->orderBy("fullname", "ASC")
			->get();
    }

    public function getHeroById($id)
    {
        return $this->connection->table('heroes')->where('id', $id)->first();
    }

    public function insertHero($data)
    {
        return $this->connection->table("heroes")->insert($data);
    }

    public function updateHero($id, $data)
    {
        return $this->connection->table("heroes")
            ->where("id", $id)
            ->update($data);
    }

    public function deleteHero($id)
    {
        return $this->connection->table("heroes")
            ->where("id", $id)
            ->delete();
    }

}