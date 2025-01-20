<?php
    
    require __DIR__ . '/../Config/Database.php';

    $database = new Database();
    $conn = $database->getConnection();

    function getTotalCourses($conn) {
        $query = "SELECT COUNT(*) as total_courses FROM course"; 
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_courses'];
    }

    function fetchAllTags($conn)
    {
        $query = "SELECT id, name FROM tags";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    function fetchAllCategories($conn)
    {
        $query = "SELECT id, name FROM category";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function fetchAllTeachers($conn)
    {
        $query = "SELECT * FROM users WHERE role = 'teacher' AND status = 'pending'";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function fetchAllUsers($conn)
    {
        $query = "SELECT * FROM users WHERE role != 'admin' AND status != 'pending' ";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

?>