<?php

class Product
{
    private $conn;
    private $table_name = 'products';

    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    public function __construct($db)
    {
        $this->conn = $db;
    }
        
    public function read()
    {
        $query = "SELECT c.name as category_name, 
                    p.id, 
                    p.name, 
                    p.description, 
                    p.price, 
                    p.category_id, 
                    p.created
            FROM " . $this->table_name . " p
                LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.created DESC";  

        $stm = $this->conn->prepare($query);
        $stm->execute();

        return $stm;
    }

    public function created()
    {
       $query = "INSERT INTO " . $this->table_name .
            " SET
                    name =:name, price=:price, description=:description, 
                    category_id=:category_id, created=:created";

        $stmt = $this->conn->prepare($query);
   
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->created = htmlspecialchars(strip_tags($this->created));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->created);
      
        if($stmt->execute()){

            return true;
        } else {
            return false;
        }

    }

    public function readOne()
    {
    
    $query = "SELECT
            c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
        FROM
            " . $this->table_name . " p
            LEFT JOIN categories c ON p.category_id = c.id
        WHERE
            p.id = ?
        LIMIT
            0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id          = $row['id']; 
        $this->name        = $row['name'];  
        $this->description = $row['description'];    
        $this->price       = $row['price'];
        
    }

    public function delete()
    {
        $query = "DELETE FROM " .$this->table_name. " WHERE id = ? ";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        if($stmt->rowCount() >=1 )
        {
            return true;
        }
      
        return false;
    }

    public function update()
    {
        $stmt = $this->conn->prepare("SELECT id FROM " .$this->table_name. " WHERE id = :id");
        $stmt->bindParam(':id',$this->id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) 
        {
            $query = "UPDATE
                " . $this->table_name . "
                SET
                    name = :name,
                    price = :price,
                    description = :description,
                    category_id = :category_id,
                    modified = :modified
                WHERE
                 id = :id";
     
            $stmt = $this->conn->prepare($query);

            // Sanitize
            $this->name         = htmlspecialchars(strip_tags($this->name));
            $this->price        = htmlspecialchars(strip_tags($this->price));
            $this->description  = htmlspecialchars(strip_tags($this->description));
            $this->category_id  = htmlspecialchars(strip_tags($this->category_id));
            $this->id           = htmlspecialchars(strip_tags($this->id));

            // BindParmam
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':name',$this->name);
            $stmt->bindParam(':price',$this->price);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':category_id',$this->category_id);
            $stmt->bindParam(':modified',$this->modified);

            $stmt->execute();

            if ($stmt->rowCount() == 1) 
            {
                return true;
            }else{
                throw new Exception("Por favor atualize os dados");
            }    
        }else{
            throw new Exception("Registo não esta cadastrado no banco de dados");
        }    
    }

    public function search($keyworks)
    {
        $sql = "SELECT * 
                    FROM " .$this->table_name."
                    WHERE name like ? 
                    or description like ?";
        
        //Sanitize
        $keyworks = htmlspecialchars(strip_tags($keyworks));
        $keyworks = "%{$keyworks}%";

        //Executar query
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1,$keyworks);
        $stmt->bindParam(2,$keyworks);
        $stmt->execute();

        return $stmt;       
    }
}


?>