<?php

    require __DIR__ . '/../../Config/Database.php';
    require __DIR__ . '/../../Classes/Tags.php';

    $database = new Database();
    $conn = $database->getConnection();

    $tags = new Tags($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $tagInput = $_POST['tags'];
        try
        {
            $tags->addTags($tagInput);
            header('Location: contentmanagement.php');
            exit;
        } 
        catch (Exception $e) 
        {
            echo "Error: " . $e->getMessage();
        }
    }
?>