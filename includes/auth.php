<?php
session_start();

require_once '../Config/Database.php';
require_once '../Classes/User.php';

$database = new Database();
$conn = $database->getConnection();

$user = new User($conn);
$error = '';

if (isset($_POST['signup'])) 
{
    $name = htmlspecialchars(trim($_POST['name'])); 
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $role = htmlspecialchars(trim($_POST['role'])); 

    if (empty($name) || empty($email) || empty($password) || empty($role)) 
    {
        $error = "All fields are required!";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $error = "Email format is not valid!";
    } 
    elseif (strlen($password) < 6) 
    {
        $error = "Password must be at least 6 characters!";
    } 
    else 
    {
        $query = "SELECT id FROM users WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) 
        {
            $error = "Email already exists!";
        } 
        else 
        {
            $result = $user->addUser($name, $email, $password, $role);

            if ($result === true) 
            {
                header("Location: login.php");
                exit();
            } 
            else 
            {
                $error = $result['message'];
            }
        }
    }
}

if (isset($_POST['login'])) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if (empty($email) || empty($password)) 
    {
        $error = "All fields are required!";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $error = "Email format is not valid!";
    } 
    else
    {
        $return = $user->loginUser($email, $password);

        if ($return['verify'] == false) 
        {
            $error = $return['message'];
        } 
        else 
        {
            
            session_start();
            $_SESSION['user_id'] = $return['user_id'];
            $_SESSION['role'] = $return['role'];

            if ($return['role'] === 'admin') 
            {
                header('Location: /admin/dashboard.php');
                exit;
            }
            if ($return['role'] === 'student') 
            {
                header('Location: index.php');
                exit;
            }
            if ($return['role'] === 'teacher') 
            {
                header('Location: teacher.php');
                exit;
            }           
        }
    }
}
?>