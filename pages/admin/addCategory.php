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
    $categoryName = trim($_POST['category']);

    if (empty($categoryName)) 
    {
        die('Category name is required.');
    }
    
    $stmt = $conn->prepare("SELECT id FROM category WHERE name = :name");
    $stmt->execute(['name' => $categoryName]);
    $existingCategory = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingCategory) 
    {
        die('Category already exists.');
    }
    
    $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
    if ($stmt->execute(['name' => $categoryName])) 
    {
        header('Location: contentmanagement.php');
    } 
    else
    {
        die('Category already exists.');
    }
    exit;
}
?>