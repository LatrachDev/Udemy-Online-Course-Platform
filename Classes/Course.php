<?php
class Course
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function create($title, $description, $teacherId, $categoryId)
    {
        if (empty($title) || empty($description) || empty($teacherId) || empty($categoryId)) 
        {
            throw new InvalidArgumentException("All fields are required.");
        }

        $sql = "INSERT INTO course (title, description, teacher_id, category_id) VALUES (?, ?, ?, ?)";
        $params = [
            $title,
            $description,
            $teacherId,
            $categoryId
        ];

        $this->db->query($sql, $params);
        return $this->db->lastInsertId();
    }

    public function getCourseById($courseId)
    {
        $sql = "
            SELECT 
                course.id,
                course.title,
                course.description,
                course.thumbnail_url,
                course.content_url,
                course.content_type,
                category.name AS category_name,
                users.name AS teacher_name
            FROM course
            JOIN category ON course.category_id = category.id
            JOIN users ON course.teacher_id = users.id
            WHERE course.id = ?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function getCourseContent($courseId)
    {
        $sql = "SELECT content_url, content_type FROM course WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$courseId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>