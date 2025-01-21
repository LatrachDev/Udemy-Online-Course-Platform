<?php

    require_once __DIR__ . '/../Config/Database.php';

    class Enrollment
    {
        private $conn;
        private $table_name;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function enrollStudent($userId, $courseId) 
        {
            $query = "INSERT INTO enrollments (user_id, course_id) VALUES (:user_id, :course_id)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":course_id", $courseId);
        
            if ($stmt->execute()) 
            {
                return true;
            } 
            else
            {
                return "Failed to enroll in the course.";
            }
        }

        public function getEnrolledCourses($studentId)
        {
            $quey = "
                SELECT course.id, course.title, course.description, course.thumbnail_url
                FROM enrollments JOIN course
                ON enrollments.course_id = course.id
                WHERE enrollments.user_id = :user_id
            ";

            $stmt = $this->conn->prepare($quey);
            $stmt->bindParam(":user_id", $studentId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function isEnrolled($studentId, $courseId) {
            $query = "SELECT id FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":student_id", $studentId);
            $stmt->bindParam(":course_id", $courseId);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        }


    }
?>