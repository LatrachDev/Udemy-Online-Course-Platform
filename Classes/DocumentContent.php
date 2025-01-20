<?php

require_once 'Content.php';
class DocumentContent extends Content
{
    private $path;
    private $fileSize;

    public function __construct($db, $courseId, $path, $fileSize)
    {
        parent::__construct($db, $courseId);

        if (empty($path) || empty($fileSize)) {
            throw new InvalidArgumentException("Path and file size are required.");
        }
        
        $this->path = $path;
        $this->fileSize = $fileSize;
    }

    public function save()
    {
        $sql = "INSERT INTO contents (course_id, type) VALUES (?, 'document')";
        $params = [
            $this->courseId
        ];

        $this->db->query($sql, $params);

        $contentId = $this->db->lastInsertId();

        $sql = "INSERT INTO document_contents (content_id, file_path, file_size) VALUES (?, ?, ?)";
        $params = [
            $contentId,
            $this->path,
            $this->fileSize
        ];

        $this->db->query($sql, $params);

        return $this->db->lastInsertId();
    }

    public function display($courseId)
    {
        $sql = "SELECT title , DESCRIPTION , TYPE , file_path FROM courses
        INNER JOIN contents ON courses.id = contents.course_id
        INNER JOIN document_contents ON contents.id = document_contents.content_id
        WHERE courses.id = ?";

        $result = $this->db->fetch($sql, [$courseId]);
        return $result;
    }
}
