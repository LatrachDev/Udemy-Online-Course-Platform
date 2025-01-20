<?php
    class Tags
    {
        private $conn;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function addTags($tagsInput)
        {
            // Normalize the tags
            $tags = array_map('trim', explode(',', $tagsInput));
            $tags = array_map('strtolower', $tags);
            $tags = array_map(function ($tag) {
                return str_replace(' ', '', $tag);
            }, $tags);
            $tags = array_filter($tags);

            if (empty($tags)) 
            {
                die("No tags provided.");
            }

            try {
                $this->conn->beginTransaction();

                foreach ($tags as $tagName) {
                    $stmt = $this->conn->prepare("SELECT id FROM tags WHERE name = :name");
                    $stmt->execute(['name' => $tagName]);
                    $tag = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($tag) 
                    {
                        $tagId = $tag['id'];
                    } 
                    else
                    {
                        $stmt = $this->conn->prepare("INSERT INTO tags (name) VALUES (:name)");
                        $stmt->execute(['name' => $tagName]);
                        $tagId = $this->conn->lastInsertId();
                    }
                }

                $this->conn->commit();
                header('Location: contentmanagement.php');
            } 
            catch (Exception $e)
            {
                $this->conn->rollback();
                echo "Error: " . $e->getMessage();
            }
        }

        public function fetchAllTags()
        {
            $sql = "SELECT id, name FROM tags";
            $stmt = $this->conn->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>