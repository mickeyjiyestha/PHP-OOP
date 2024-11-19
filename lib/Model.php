<?php
require(__DIR__ . '/../Config/init.php');

class Model
{
    protected $db;
    protected $tableName;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function setTableName($products)
    {
        $this->tableName = $products;
    }

    public function fetchAll() {
        if (!$this->tableName) {
            throw new Exception("Table name is not set");
        }

        $query = "SELECT * FROM {$this->tableName}";
    
        $stmt = $this->db->getInstance()->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}