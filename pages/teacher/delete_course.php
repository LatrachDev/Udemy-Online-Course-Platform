<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') 
{
    header('Location: /../errors/403.php');
    exit;
}

require_once '../../Config/Database.php';
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['course_id'])) 
{
    $course_id = $_POST['course_id'];

    $stmt = $conn->prepare("DELETE FROM course WHERE id = ?");
    $stmt->execute([$course_id]);

    header('Location: teacher_courses.php');
    exit;
} 
else 
{
    die("Invalid request.");
}
?>