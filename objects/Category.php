<?php

class Category 
{
    private $conn;
    private $table_name = 'categories';

    public $id;
    public $name;
    public $description;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read(){

        $sql = "SELECT 
                    c.id,
                    c.name,
                    c.description,
                    c.created
                FROM " .$this->table_name. " c";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }
}