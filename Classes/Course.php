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
}
