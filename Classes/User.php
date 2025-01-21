<?php

class User {
    private $conn;
    private $table_name = "users";

    public $name;
    public $email;
    public $password;
    public $role;

    public function __construct($db) 
    {
        $this->conn = $db;
    }

    public function addUser($name, $email, $password, $role, $status) 
    {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role, status) VALUES (:name, :email, :password, :role, :status)";
        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":status", $status);

        if ($stmt->execute()) 
        {
            return true;
        } 
        else 
        {
            return ['message' => "Unable to create user."];
        }
    }

    public function loginUser($email, $password) 
    {
        $query = "SELECT id, name, password, role, status FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) 
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $row['name'];
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) 
            {
                return [
                    'verify' => true,
                    'user_id' => $row['id'],
                    'role' => $row['role'],
                    'name' => $row['name'],
                    'status' => $row['status']
                ];
            } 
            else 
            {
                return [
                    'verify' => false,
                    'message' => "Incorrect password."
                ];
            }
        } 
        else 
        {
            return [
                'verify' => false,
                'message' => "User not found."
            ];
        }
    }

    public function getTopTeachers() {
        $query = "
            SELECT u.id, u.name,
                   COUNT(DISTINCT c.id) as course_count,
                   COUNT(DISTINCT e.user_id) as student_count
            FROM users u
            LEFT JOIN course c ON u.id = c.teacher_id
            LEFT JOIN enrollments e ON c.id = e.course_id
            WHERE u.role = 'teacher' AND u.status = 'active'
            GROUP BY u.id, u.name
            ORDER BY student_count DESC
            LIMIT 3
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>