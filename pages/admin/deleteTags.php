<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: errors/403.php');
    exit;
}

require_once '../../Config/Database.php';

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tag_id'])) {
    $tag_id = $_POST['tag_id'];

    
    $query = "DELETE FROM tags WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $tag_id);

    if ($stmt->execute()) {
       
        header('Location: contentmanagement.php');
        exit;
    }
}
?>