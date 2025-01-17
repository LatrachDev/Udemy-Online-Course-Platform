<?php

class User {
    private $conn;
    private $table_name = "users";

    public $name;
    public $email;
    public $password;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addUser($name, $email, $password, $role) {
        $query = "INSERT INTO " . $this->table_name . " (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($query);

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);

        if ($stmt->execute()) {
            return true;
        } else {
            return ['message' => "Unable to create user."];
        }
    }

    public function loginUser($email, $password) {
        $query = "SELECT id, password, role FROM " . $this->table_name . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                return [
                    'verify' => true,
                    'user_id' => $row['id'],
                    'role' => $row['role']
                ];
            } else {
                return [
                    'verify' => false,
                    'message' => "Incorrect password."
                ];
            }
        } else {
            return [
                'verify' => false,
                'message' => "User not found."
            ];
        }
    }


}
?>