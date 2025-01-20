<?php 
    class Category
    {
        private $conn;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function addCategory($name)
        {
            if (empty($name)) 
            {
                die("No tags provided.");
            }
            
            $stmt = $this->conn->prepare("SELECT id FROM categories WHERE name = :name");
            $stmt->execute(['name' => $name]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($category) 
            {
                die("Category already exists.");
            }
            $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute(['name' => $name]);
            return $this->conn->lastInsertId();

        }

        public function fetchAllCategories()
        {
            $sql = "SELECT id, name FROM category";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); 
        }
    
        
    }
?>