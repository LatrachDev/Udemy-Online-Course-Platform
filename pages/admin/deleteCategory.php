<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: /../errors/403.php');
        exit;
    }

    require __DIR__ . '/../../Config/Database.php';


    $database = new Database();
    $conn = $database->getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $categoryId = $_POST['category_id'];

        $stmt = $conn->prepare("DELETE FROM category WHERE id = :id");
        if($stmt->execute(['id' => $categoryId]))
        {
            header('Location: contentmanagement.php');
            exit;
        }
    }
?>
