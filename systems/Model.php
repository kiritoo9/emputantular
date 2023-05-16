<?php

namespace Empu;

/**
 * Empu-Model Module
 * -------
 * Model
 * For your entities
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;
use Empu\DB;

class Model extends Core 
{
    protected array $__schema = [];
    protected array $__fieldActive = [];
    protected int $__recallIndex = 0;
    protected $connection = null;

    public function __construct()
    {
        $this->__schema = [
            'tablename' => null,
            'fields' => []
        ];
        $this->cleanUpField();

        $this->connection = new DB();
    }

    protected function cleanUpField(): void
    {
        if(isset($this->__fieldActive['column']) && $this->__fieldActive['column'] !== null) {
            $this->__schema['fields'][] = $this->__fieldActive;
        }

        $this->__fieldActive = [
            'column' => null,
            'type' => null,
            'length' => null,
            'default' => null,
            'comment' => null,
            'nullable' => null,
            'primary_key' => null,
            'foreign_key' => null,
            'foreign_references' => null,
            'on_delete' => null,
            'on_update' => null
        ];
    }

    public function schema(string $tablename, $callback)
    {
        $this->__schema['tablename'] = $tablename;
        if (is_callable($callback)) 
            $callback($this);

        $this->cleanUpField();
        try {
            $this->commit();
            exit("Table {$tablename} is successfully migrated!\n");
        } catch(Throwable $e) {
            exit('Something went wrong: '.$e."\n");
        }
    }

    /**
     * Column Attributes
     * -----
     * 
     * Attributes of column you defined
     * */

    public function primary_key()
    {
        $this->__fieldActive['primary_key'] = true;
        $this->__fieldActive['nullable'] = false;

        return $this;
    }

    public function foreign_key(string $value)
    {
        $this->cleanUpField();
        for($i=0; $i<count($this->__schema['fields']); $i++) {
            if($this->__schema['fields'][$i]['column'] === $value) {
                $this->__recallIndex = $i;
                break;
            }
        }
        $this->__schema['fields'][$this->__recallIndex]['foreign_key'] = $value;
        return $this;
    }

    public function references(string $value)
    {
        $this->__schema['fields'][$this->__recallIndex]['foreign_references'] = $value;
        return $this;
    }

    public function on_delete(string $value)
    {
        $this->__schema['fields'][$this->__recallIndex]['on_delete'] = $value;
        return $this;
    }

    public function on_update(string $value)
    {
        $this->__schema['fields'][$this->__recallIndex]['on_update'] = $value;
        return $this;
    }

    public function length(int $value)
    {
        $this->__fieldActive['length'] = $value;
        return $this;
    }

    public function comment(string $value)
    {
        $this->__fieldActive['comment'] = $value;
        return $this;
    }

    public function default(string $value)
    {
        $this->__fieldActive['default'] = $value;
        return $this;
    }

    public function nullable(bool $value)
    {
        $this->__fieldActive['nullable'] = $value;
        return $this;
    }

    /**
     * Data Type Properties
     * -----
     * 
     * Column type will set automatically with this function
     * */

    public function uuid(string $column)
    {
        $this->cleanUpField();
        $this->__fieldActive['type'] = 'uuid';
        $this->__fieldActive['column'] = $column;

        return $this;
    }

    public function varchar(string $column)
    {
        $this->cleanUpField();
        $this->__fieldActive['type'] = 'varchar';
        $this->__fieldActive['column'] = $column;

        return $this;
    }

    public function text(string $column)
    {
        $this->cleanUpField();
        $this->__fieldActive['type'] = 'text';
        $this->__fieldActive['column'] = $column;

        return $this;
    }

    public function float(string $column)
    {
        $this->cleanUpField();
        $this->__fieldActive['type'] = 'float';
        $this->__fieldActive['column'] = $column;

        return $this;
    }

    public function numeric(string $column)
    {
        $this->cleanUpField();
        $this->__fieldActive['type'] = 'numeric';
        $this->__fieldActive['column'] = $column;

        return $this;
    }

    /**
     * Actions Handler
     * -----
     * 
     * */

    public function commit(): void
    {
        $schema = (object)$this->__schema;
        $query = "CREATE TABLE IF NOT EXISTS {$schema->tablename} (";
            $qcomments = null;
            $foreigns = [];
            foreach ($schema->fields as $row => $value) {
                $value = (object)$value;

                $_primaryKey = $value->primary_key ? "PRIMARY KEY" : null;

                $value->length = (int)$value->length;
                $_length = "({$value->length})";
                if($_primaryKey || $value->length <= 0) $_length = null;
                
                $_default = null;
                if($value->default) $_default = "DEFAULT '{$value->default}'";

                $_nullable = (bool)$value->nullable ? "NULL" : "NOT NULL";

                $query .= "{$value->column} {$value->type}{$_length} {$_default} {$_nullable} {$_primaryKey}".($row<(count($schema->fields)-1) ? ",": null);

                if($value->foreign_key) $foreigns[] = $value;
                if($value->comment) {
                    $qcomments .= "COMMENT ON COLUMN {$schema->tablename}.{$value->column} IS '{$value->comment}';";
                }
            }
            
            foreach ($foreigns as $row => $value) {
                $_onDelete = $value->on_delete ? "ON DELETE {$value->on_delete}" : null;
                $_onUpdate = $value->on_update ? "ON UPDATE {$value->on_update}" : null;
                $query .= ($row === 0 ? "," : null)."FOREIGN KEY ({$value->foreign_key}) REFERENCES {$value->foreign_references} {$_onDelete} {$_onUpdate}".($row<(count($foreigns)-1) ? "," : null);
            }

        $query .= ");";
        $query .= $qcomments;

        $this->connection->exec($query);
        $this->connection = null;
    }

    public function schema_drop(string $tablename = ''): void
    {
        if($this->connection && $tablename) {
            $this->connection->raw("DROP TABLE {$tablename}");
            $this->connection = null;
            exit("Drop table {$tablename} is successfully!"."\n");
        }
        exit('Something went wrong!'."\n");
    }
}