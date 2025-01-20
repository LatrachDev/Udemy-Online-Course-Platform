<?php 
require_once 'Content.php';
class VideoContent extends Content
{
    private $videoUrl;

    public function __construct($db, $courseId, $videoUrl)
    {
        parent::__construct($db, $courseId);
        $this->videoUrl = $videoUrl;
    }

    public function save()
    {
        $stmt = $this->db->prepare("INSERT INTO course_content (course_id, content_type, content_url) VALUES (?, 'video', ?)");
        $stmt->execute([$this->courseId, $this->videoUrl]);
    }

    public function display($courseId)
    {
        $stmt = $this->db->prepare("SELECT content_url FROM course_content WHERE course_id = ? AND content_type = 'video'");
        $stmt->execute([$courseId]);
        $videoUrl = $stmt->fetchColumn();

        return "<video controls><source src='$videoUrl' type='video/mp4'>Your browser does not support the video tag.</video>";
    }
}