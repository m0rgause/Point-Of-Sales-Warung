<?php

/*
 * I make this model because, i use postgresql database and need to use uuid type for primary key column.
 * If use built in insert method from query builder class, i have this error
 *
 * pg_query(): Query failed: ERROR: lastval is not yet defined in this session
 *
 * the error because my table no have a primary key column in format serial
*/

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;

class POSWModel
{
    public function __construct(ConnectionInterface $db, string $table)
    {
        $this->db = $db;
        $this->table = $table;
    }

    private function generateColumnString(array $data): string
    {
        $column = '';
        foreach($data as $key => $value) {
            $column .= $key.',';
        }
        return rtrim($column, ',');
    }

    private function generateValuesString(array $data): string
    {
        $values = '';
        foreach($data as $key => $value) {
            $values .= ':'.$key.':,';
        }
        return rtrim($values, ',');
    }

    public function insert(array $dataInsert): bool
    {
        $sql = 'INSERT INTO '.$this->table.' ('.$this->generateColumnString($dataInsert).')
                VALUES ('.$this->generateValuesString($dataInsert).')';
        $this->db->query($sql, $dataInsert);
        return true;
    }
}
