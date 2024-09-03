<?php

namespace core;

use ReflectionClass;

class Model
{
    protected $db;
    protected $table;
    protected $entityClass;
    protected $assocArrayMode = false;

    public function __construct($db, $assocArrayMode = false)
    {
        $this->db = $db;
        $this->assocArrayMode = $assocArrayMode;
        $this->setTable();
        $this->setEntityClass();
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table (";
        foreach ($data as $key => $value) {
            $sql .= "$key, ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= ') VALUES (';
        foreach ($data as $key => $value) {
            $sql .= ":$key, ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= ')';
        try {
            $stmt = $this->db->prepare($sql);
            $res = $stmt->execute($data);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            exit;
        }
        if ($res) {
            return $this->getById($this->db->lastInsertId());
        }
        return null;
    }

    public function getAll($asAssocArray = false)
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->db->query($sql);
        $dbData = $stmt->fetchAll();

        return $this->getFormatedRecords($dbData);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $dbData = $stmt->fetch();
        if ($dbData) {
            return $this->formatRecord($dbData);
        }
        return null;
    }

    public function deleteById($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function updateById($data)
    {
        $sql = "UPDATE $this->table SET ";
        foreach ($data as $key => $value) {
            $sql .= "$key = :$key, ";
        }
        $sql = rtrim($sql, ', ');
        $sql .= " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function getOneBy($column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = :$column LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$column => $value]);
        $dbData = $stmt->fetch();
        if ($dbData) {
            return $this->formatRecord($dbData);
        }
        return null;
    }

    public function getByColumn($column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE $column = :$column";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$column => $value]);
        $dbData = $stmt->fetchAll();

        return $this->getFormatedRecords($dbData);
    }

    public function getByQuery(array $query)
    {
        $sql = "SELECT * FROM $this->table WHERE ";

        $sql .= implode(' AND ', array_map(function ($key) use ($query) {
            return "$key " . $query[$key]['op'] . " :$key";
        }, array_keys($query)));

        $stmt = $this->db->prepare($sql);
        $values = [];
        foreach ($query as $key => $params) {
            $values[$key] = $params["value"];
        }
        $stmt->execute($values);
        $dbData = $stmt->fetchAll();
        return $this->getFormatedRecords($dbData);
    }


    // function to search by query based on mutlipe columns related by OR
    public function getByQueryOr(array $query)
    {
        $sql = "SELECT * FROM $this->table WHERE ";

        $sql .= implode(' OR ', array_map(function ($key) use ($query) {
            return "$key " . $query[$key]['op'] . " :$key";
        }, array_keys($query)));

        $stmt = $this->db->prepare($sql);
        $values = [];
        foreach ($query as $key => $params) {
            $values[$key] = $params["value"];
        }
        $stmt->execute($values);
        $dbData = $stmt->fetchAll();
        return $this->getFormatedRecords($dbData);
    }

    // function to search by query based on date exacly
    public function getByQueryDate($column, $value)
    {
        $sql = "SELECT * FROM $this->table WHERE DATE($column) = DATE(:$column)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$column => $value]);
        $dbData = $stmt->fetchAll();
        return $this->getFormatedRecords($dbData);
    }

    // function to search by query based on date less than
    public function getByQueryDateLessThan($column, $value)
    {
        $value = date("Y-m-d", strtotime("$value +1 day"));
        $sql = "SELECT * FROM $this->table WHERE $column <= DATE(:$column)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$column => $value]);
        $dbData = $stmt->fetchAll();
        if (!$dbData) {
            return [];
        }
        return $this->getFormatedRecords($dbData);
    }

    protected function createEntity($dbData)
    {
        return new $this->entityClass($dbData);
    }

    protected function getFormatedRecords($dbData)
    {
        if (!$dbData) {
            return [];
        }

        $entities = [];
        foreach ($dbData as $data) {
            $record = $this->formatRecord($data);
            $id = $data['id'];
            if ($id && !isset($entities[$id])) {
                // record has not been added to the array yet
                $entities[$id] = $record;
            } elseif ($id) {
                // the index is already taken. we move the current record to the end of the array
                $entities[] = $entities[$id];
                $entities[$id] = $record;
            } else {
                $entities[] = $record;
            }
        }
        return $entities;
    }

    protected function formatRecord($data)
    {
        if ($this->assocArrayMode) {
            return $this->createAssoc($data);
        }
        return $this->createEntity($data);
    }

    protected function createAssoc($data)
    {
        $assoc = [];
        foreach ($data as $key => $value) {
            if (!is_numeric($key)) {
                $assoc[$key] = $value;
            }
        }
        return $assoc;
    }

    protected function setTable()
    {
        $className = $this->getMainClassName();
        $table = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $className));
        $this->table = str_ends_with($table, 'y') ? substr($table, 0, -1) . 'ies' : $table . 's';
    }

    protected function setEntityClass()
    {
        $this->entityClass = 'entities\\' . $this->getMainClassName();
    }

    protected function getMainClassName()
    {
        $className = (new ReflectionClass($this))->getShortName();
        return str_replace('Model', '', $className);
    }
}
