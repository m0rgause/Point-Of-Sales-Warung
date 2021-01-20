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

    /*
    |------------------------
    | Simple Insert
    |----------------------------
    */

    private function generateColumnsString(array $data): string
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

    public function insert(array $data_insert): bool
    {
        $sql = 'INSERT INTO '.$this->table.' ('.$this->generateColumnsString($data_insert).')
                VALUES ('.$this->generateValuesString($data_insert).')';
        $this->db->query($sql, $data_insert);
        return true;
    }

    /*
    |------------------------
    | Insert Returning
    |----------------------------
    | If insert success, return a value from new data was inserted, ex. id
    */

    public function insertReturning(array $data_insert, string $field_return): bool
    {
        $sql = 'INSERT INTO '.$this->table.' ('.$this->generateColumnsString($data_insert).')
            VALUES ('.$this->generateValuesString($data_insert).') RETURNING '.$this->db->escapeString($field_return);

        try {
            $insert = $this->db->query($sql, $data_insert);
            $this->insert_return = $insert->getRowArray()['produk_id'];

        } catch(\ErrorException $e) {
            return false;
        }

        return true;
    }

    public function getInsertReturning(): ? string
    {
        return $this->insert_return??null;
    }

    /*
    |------------------------
    | Insert Batch
    |----------------------------
    */

    private function generateQuestionMarks(array $data): string
    {
        $question_marks = '';
        $count_data = count($data);
        for($i = 0; $i < $count_data; $i++) {
            $question_marks .= '('.str_repeat('?,', count($data[$i])-1).'?),';
        }
        return rtrim($question_marks, ',');
    }

    private function generateDataInsertBatch(array $data): array
    {
        $data_insert_batch = [];
        $count_data = count($data);
        for($i = 0; $i < $count_data; $i++) {
            foreach($data[$i] as $value) {
                array_push($data_insert_batch, $value);
            }
        }
        return $data_insert_batch;
    }

    public function insertBatch(array $data_insert)
    {
        $sql = 'INSERT INTO '.$this->table.' ('.$this->generateColumnsString($data_insert[0]).')
            VALUES '.$this->generateQuestionMarks($data_insert);
        try {
            $insert = $this->db->query($sql, $this->generateDataInsertBatch($data_insert));
        } catch(\ErrorException $e) {
            return false;
        }

        return true;
    }
}
