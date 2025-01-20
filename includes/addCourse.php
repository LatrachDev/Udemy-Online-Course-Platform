<?php 
    session_start();

    require __DIR__ . '/../Config/Database.php';
    require __DIR__ . '/../Config/Course.php';
    require __DIR__ . '/../Config/VideoContent.php';
    require __DIR__ . '/../Config/DocumentContent.php';

    $db = new Database();
    $conn = $db->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $teacherId = $_SESSION['user_id']; 
        $categoryId = $_POST['category'];
        $tags = $_POST['tags']; //(array of tag id)

        
    }
?>