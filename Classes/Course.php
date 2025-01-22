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

    public function getTotalCourses($teacher_id) 
    {
        $query = "SELECT COUNT(*) AS total_courses FROM course WHERE teacher_id = :teacher_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_courses'];
    }

    public function getTotalEnrolledStudents($teacher_id) 
    {
        $query = "
            SELECT COUNT(DISTINCT e.user_id) AS total_students
            FROM enrollments e
            JOIN course c ON e.course_id = c.id
            JOIN users u ON e.user_id = u.id
            WHERE c.teacher_id = :teacher_id AND u.role = 'student'
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':teacher_id', $teacher_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_students'];
    }
}

?>