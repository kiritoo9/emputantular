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
    public int $global_limit = 0;
    public int $global_offset = 0;

    public function table($tablename)
    {
        $this->global_table = $tablename;
        return $this;
    }

	public function select(...$params)
	{
        for($i=0; $i<count($params);$i++) {
            $this->global_select[] = $params[$i];
        }
        return $this;
	}

    public function where($field, $operator, $value = null)
    {
        if(!$value) {
            $value = $operator;
            $operator = '=';
        }
        if (is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        $w = [
            'field' => $field,
            'operator' => $operator,
            'value' => $value
        ];
        $this->global_where[] = $w;
        return $this;
    }

    public function join($tableTarget, $firstKey, $secondKey, $type = 'LEFT')
    {
        $this->global_join[] = [
            'tableTarget' => $tableTarget,
            'firstKey' => $firstKey,
            'secondKey' => $secondKey,
            'type' => $type
        ];
        return $this;
    }

    public function orderBy($field, $type = 'ASC')
    {
        $this->global_order[] = [
            'field' => $field,
            'type' => $type
        ];
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
        return $this->translateQuery('all');
    }

    public function first()
    {
        return $this->translateQuery('first');
    }

    public function insert(array $data = [])
    {
        $query = "INSERT INTO {$this->global_table} ";
        $value_str = "";
        $index = 0;
        $where_params = [];

        foreach ($data as $row => $value) {
            $query .= ($index === 0 ? '(' : null)." {$row} ".($index < (count($data)-1) ? ',' : ')');

            /**
             * Use Classic
             * ----
             * $value = is_string($value) ? " '{$value}' " : $value;
             * $value_str .= ($index === 0 ? '(' : null)." {$value} ".($index < (count($data)-1) ? ',' : ')');
             * */

            /**
             * Use Statement
             * */
            $value_str .= ($index === 0 ? '(' : null)." :{$row} ".($index < (count($data)-1) ? ',' : ')');
            $index++;
            $where_params[$row] = $value;
        }
        $query = "{$query} VALUES {$value_str};";

        /**
         * Use Classic
         * -> return $this->executeQuery($query);
         * ------
         * 
         * Use Statement
         * -> return $this->executeStatementQuery($query, $where_params)
         * */

        return $this->executeStatementQuery($query, $where_params);
    }

    public function update(array $data = [])
    {
        if(count($this->global_where) <= 0) throw new \Exception('You did not define conditions yet!');

        $query = "UPDATE {$this->global_table} SET ";
        $where_params = [];

        foreach ($data as $row => $value) {
            /**
             * Use Classic
             * -----
             * $value = is_string($value) ? " '{$value}' " : $value;
             * $query .= " {$row} = {$value} ".($index < (count($data)-1) ? ',' : null);
             * */

            /**
             * Use Statement
             * ----
             * */

            $query .= " {$row} = :{$row} ".($row < (count($data)-1) ? ',' : null);
            $where_params[$row] = $value;
        }

        /**
         * Use Classic
         * -> $query .= $this->translateWhere();
         * -> return $this->executeQuery($query);
         * ------
         * 
         * Use Statement
         * -> $response = $this->translateStatementWhere();
         * -> return $this->executeStatementQuery($query, $where_params)
         * */

        $wresponse = $this->translateStatementWhere();
        $query .= $wresponse["query"];
        $where_params = array_merge($where_params, $wresponse["where_params"]);
        return $this->executeStatementQuery($query, $where_params);
    }

    public function delete()
    {
        if(count($this->global_where) <= 0) throw new \Exception('You did not define conditions yet!');

        $query = "DELETE FROM {$this->global_table} ";

        /**
         * Use Classic
         * -> $query .= $this->translateWhere();
         * -> return $this->executeQuery($query);
         * ------
         * 
         * Use Statement
         * -> $response = $this->translateStatementWhere();
         * -> return $this->executeStatementQuery($query, $where_params)
         * */

        $wresponse = $this->translateStatementWhere();
        $query .= $wresponse["query"];
        $where_params = $wresponse["where_params"];
        return $this->executeStatementQuery($query, $where_params);
    }

    public function raw(String $raw)
    {
        return $this->executeQuery($raw);
    }

    public function exec(String $raw)
    {
        return $this->executeQuery($raw, 'all', 'exec');
    }

    /**
     * 
     * Core libs
     * Generate to sql query
     * @var string type = all|first
     **/

    private function translateWhere(): string
    {
        $query = "";
        foreach ($this->global_where as $row => $value) {
            $value = (object)$value;
            $__value = is_string($value->value) ? " '{$value->value}' " : $value->value;

            $query .= ($row === 0 ? " WHERE " : null)." {$value->field} = {$__value} ".($row < (count($this->global_where)-1) ? " AND " : null);
        }

        return $query;
    }

    private function translateStatementWhere(): array
    {
        $response = [
            "query" => "",
            "where_params" => []
        ];
        foreach ($this->global_where as $row => $value) {
            $value = (object)$value;

            $response["query"] .= ($row === 0 ? " WHERE " : null)." {$value->field} = :{$value->field} ".($row < (count($this->global_where)-1) ? " AND " : null);
            $response["where_params"][$value->field] = $value->value;
        }

        return $response;
    }

    private function translateQuery($type = 'all')
    {
        $query = "SELECT ";
        foreach ($this->global_select as $rs => $vs) {
            $query .= ($rs === 0 ? null : ',')." {$vs} ";
        }
        if(count($this->global_select) <= 0) $query .= " * ";
        $query .= " FROM {$this->global_table} ";

        foreach ($this->global_join as $rj => $vj) {
            $vj = (object)$vj;
            $query .= " {$vj->type} JOIN {$vj->tableTarget} ON {$vj->firstKey} = {$vj->secondKey} ";
        }

        if(count($this->global_where) > 0) $query .= " WHERE ";

        $where_params = [];
        foreach ($this->global_where as $rw => $vw) {
            $vw = (object)$vw;

            /**
             * Use Classic
             * -------
                $_value = is_string($vw->value) ? "'{$vw->value}'" : $vw->value;

                if(is_null($_value)) {
                    $_value = ($vw->operator === '=' ? 'is' : 'is not')." null ";
                    $vw->operator = null;
                }
            **/

            /**
             * Use Statement
             * -------
             * */

            $query .= ($rw === 0 ? null : ' AND ')." {$vw->field} {$vw->operator} :{$vw->field} ";
            $where_params[$vw->field] = $vw->value;
        }

        if(count($this->global_order) > 0) $query .= " ORDER BY ";
        foreach ($this->global_order as $ro => $vo) {
            $vo = (object)$vo;
            $query .= ($ro === 0 ? null : ',')." {$vo->field} {$vo->type} ";
        }

        if(strtolower($type) === 'all') {
            if($this->global_limit && $this->global_limit > 0) $query .= " LIMIT {$this->global_limit} ";
            if($this->global_offset && $this->global_offset > 0) $query .= " OFFSET {$this->global_offset} ";
        } else if(strtolower($type) === 'first') {
            $query .= " LIMIT 1 OFFSET 0 ";
        }

        return $this->executeQuery($query, $type, null, $where_params);
    }

    private function executeQuery(String $raw = '', String $type = 'all', String $exec_type = null, array $where_params = [])
    {
        $this->init(); // OPEN CONNECTION

        $data = [];
        if($exec_type === 'exec') {
            $data = $this->database_connection->exec($raw);
        } else {
            if(count($where_params) > 0) {
                $response = $this->database_connection->prepare($raw);
                $response->execute($where_params);
            } else {
                $response = $this->database_connection->query($raw);
            }

            /**
             * Convert data to object
             * */
            $index = 0;
            while($row = $response->fetch(\PDO::FETCH_ASSOC)) {
                if(strtolower($type) === 'all') {
                    $data[] = (object)$row;
                } else if(strtolower($type) === 'first' && $index === 0) {
                    $data = (object)$row;
                    break;
                }
                $index++;
            }
        }

        $this->database_connection = null; // CLOSE CONNECTION
        return $data;
    }

    private function executeStatementQuery(string $query = "", array $where_params = [])
    {
        $this->init();
        $response = $this->database_connection->prepare($query);
        $response = $response->execute($where_params);
        $this->database_connection = null; // CLOSE CONNECTION
        return $response;
    }

}