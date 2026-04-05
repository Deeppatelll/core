<?php

require_once 'app/models/Core/Database.php';

class Model_Core_Table
{
    protected $_tablename = null;
    protected $_primarykey = null;

    protected $data = [];
    protected $adapter = null;

    public function __construct()
    {
    }

    public function setTableName($tablename)
    {
        $this->_tablename = $tablename;
    }

    public function getTableName()
    {
        return $this->_tablename;
    }

    public function setPrimaryKey($primarykey)
    {
        $this->_primarykey = $primarykey;
    }

    public function getPrimaryKey()
    {
        return $this->_primarykey;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
    }

    public function getAdapter()
    {
        if (!$this->adapter) {
            $this->adapter = new Model_Core_Database();
            $this->adapter->connection();
        }
        return $this->adapter;
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

    // Load a single record by primary key
    public function load($id)
    {
        $table = $this->getTableName();
        $pk = $this->getPrimaryKey();
        $id = $this->getAdapter()->escape($id);
        $sql = "SELECT * FROM `$table` WHERE `$pk` = '$id'";
        $row = $this->getAdapter()->fetchRow($sql);

        if ($row) {
            $this->data = $row;
        }
        return $this;
    }

    // Fetch all records
    public function fetchAll()
    {
        $table = $this->getTableName();
        $sql = "SELECT * FROM `$table`";
        $rows = $this->getAdapter()->fetchAll($sql);
        return $rows ? $rows : [];
    }

    // Insert a new record
    public function insert()
    {
        $data = $this->data;
        // Remove primary key if empty (auto-increment)
        $pk = $this->getPrimaryKey();
        if (array_key_exists($pk, $data) && empty($data[$pk])) {
            unset($data[$pk]);
        }

        $keys = array_keys($data);
        $columns = implode("`, `", $keys);

        $values = [];
        foreach ($data as $value) {
            $values[] = $this->getAdapter()->escape($value);
        }
        $valuesStr = implode("', '", $values);

        $table = $this->getTableName();
        $sql = "INSERT INTO `$table` (`$columns`) VALUES ('$valuesStr')";

        return $this->getAdapter()->insert($sql);
    }

    // Update an existing record
    public function update()
    {
        $data = $this->data;
        $pk = $this->getPrimaryKey();
        $id = $this->getAdapter()->escape($data[$pk]);
        unset($data[$pk]);

        $setParts = [];
        foreach ($data as $key => $value) {
            $escaped = $this->getAdapter()->escape($value);
            $setParts[] = "`$key` = '$escaped'";
        }
        $setStr = implode(", ", $setParts);

        $table = $this->getTableName();
        $sql = "UPDATE `$table` SET $setStr WHERE `$pk` = '$id'";

        return $this->getAdapter()->update($sql);
    }

    // Save – insert or update based on primary key presence
    public function save()
    {
        $pk = $this->getPrimaryKey();
        if (!empty($this->data[$pk])) {
            $this->data['updated_date'] = date('Y-m-d H:i:s');
            return $this->update();
        }
        $this->data['created_date'] = date('Y-m-d H:i:s');
        return $this->insert();
    }

    // Delete a record by primary key
    // public function delete()
    // {
    //     $table = $this->getTableName();
    //     $pk = $this->getPrimaryKey();
    //     $id = $this->getAdapter()->escape($this->data[$pk]);
    //     $sql = "DELETE FROM `$table` WHERE `$pk` = '$id'";
    //     return $this->getAdapter()->delete($sql);
    // }
    public function delete()
    {
        $table = $this->getTableName();
        $pk = $this->getPrimaryKey();

        if (empty($this->data[$pk])) {
            return false;
        }

        $id = $this->getAdapter()->escape($this->data[$pk]);

        $sql = "DELETE FROM `$table` WHERE `$pk` = '$id'";
        return $this->getAdapter()->delete($sql);
    }
}

