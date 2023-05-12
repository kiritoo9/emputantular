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

    public string $global_table = '';
    public array $global_select = [];
    public array $global_where = [];
    public array $global_join = [];
    public array $global_order = [];
    public int $global_limit;
    public int $global_offset;

    public function table($tablename)
    {
        $this->global_table = $tablename;
        return $this;
    }

	public function select(...$params)
	{
        for($i=0; $i<count($params);$i++) {
            array_push($this->global_select, $params[$i]);
        }
        return $this;
	}

    public function where($field, $operator, $value = null)
    {
        if(!$value) {
            $value = $operator;
            $operator = '=';
        }
        $w = [
            'field' => $field,
            'operator' => $operator,
            'value' => $value
        ];
        array_push($this->global_where, $w);
        return $this;
    }

    public function join($tableTarget, $firstKey, $secondKey, $type = 'LEFT')
    {
        array_push($this->global_join, [
            'tableTarget' => $tableTarget,
            'firstKey' => $firstKey,
            'secondKey' => $secondKey,
            'type' => $type
        ]);
        return $this;
    }

    public function orderBy($field, $type = 'ASC')
    {
        array_push($this->global_order, [
            'field' => $field,
            'type' => $type
        ]);
        return $this;
    }

    public function limit($value)
    {
        $this->global_limit = (int)$value;
        return $this;
    }

    public function offset($value)
    {
        $this->global_offset = (int)$value;
        return $this;
    }

    public function get()
    {
        $this->translateQuery('all');
    }

    public function first()
    {
        $this->translateQuery('first');
    }

    public function raw(String $raw)
    {
        $this->executeQuery($raw);
    }

    /**
     * 
     * Core libs
     * Generate to sql query
     * @var string type = all|first
     **/

    private function translateQuery($type = 'all'): void
    {
        $query = "SELECT ";
        foreach ($this->global_select as $rs => $vs) {
            $query .= ($rs === 0 ? null : ',')." {$vs} ";
        }
        $query .= " FROM {$this->global_table} ";

        foreach ($this->global_join as $rj => $vj) {
            $vj = (object)$vj;
            $query .= " {$vj->type} JOIN {$vj->tableTarget} ON {$vj->firstKey} = {$vj->secondKey} ";
        }

        if(count($this->global_where) > 0) $query .= " WHERE ";
        foreach ($this->global_where as $rw => $vw) {
            $vw = (object)$vw;
            $_value = (int)$vw->value === 0 ? "'{$vw->value}'" : (int)$vw->value;

            if(is_null($_value)) {
                $_value = ($vw->operator === '=' ? 'is' : 'is not')." null ";
                $vw->operator = null;
            }

            $query .= ($rw === 0 ? null : ' AND ')." {$vw->field} {$vw->operator} {$_value} ";
        }

        if(count($this->global_order) > 0) $query .= " ORDER BY ";
        foreach ($this->global_order as $ro => $vo) {
            $vo = (object)$vo;
            $query .= ($ro === 0 ? null : ',')." {$vo->field} {$vo->type} ";
        }

        if(strtolower($type) === 'all') {
            if($this->global_limit) {
                $query .= " LIMIT {$this->global_limit} ";
                $query .= " OFFSET {$this->global_offset} ";
            }
        } else if(strtolower($type) === 'first') {
            $query .= " LIMIT 1 OFFSET 0 ";
        }

        $this->executeQuery($query);
    }

    private function executeQuery(String $raw = ''): void 
    {
        echo "<pre>";
        print_r($raw);
    }

}