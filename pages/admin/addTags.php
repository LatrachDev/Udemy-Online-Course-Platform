<?php

    require __DIR__ . '/../../Config/Database.php';

    $database = new Database();
    $conn = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $tagInput = $_POST['tags'];

        $tags = array_map('trim', explode(',', $tagInput));
        $tags = array_map('strtolower', $tags);
        $tags = array_map(function($tags){
            return str_replace(' ', '', $tags);
        }, $tags);

        $tags = array_filter($tags);

        if (empty($tags))
        {
            die("No tags provided.");
        }

        try
        {
            $conn->beginTransaction();

            foreach($tags as $tagName)
            {
                $stmt = $conn->prepare("SELECT id FROM tags WHERE name = :name");
                $stmt->execute(['name' => $tagName]);
                $tag = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($tag) 
                {
                    $tagId = $tag['id'];
                }
                else
                {
                    $stmt = $conn->prepare("INSERT INTO tags (name) VALUES (:name)");
                    $stmt->execute(['name' => $tagName]);
                    $tagId = $conn->lastInsertId();
                }
            }
            $conn->commit();
            header('Location: contentmanagement.php');
        }
        catch (Exception $e)
        {
            $conn->rollback();
            echo "Error: " . $e->getMessage();
        }

    }
?>