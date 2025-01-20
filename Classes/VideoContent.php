<?php 
require_once 'Content.php';
class VideoContent extends Content
{
    private $vidUrl;
    private $duration;

    public function __construct($db, $courseId, $vidUrl, $duration)
    {
        parent::__construct($db, $courseId);
        $this->vidUrl = $vidUrl;
        $this->duration = $duration;
    }

    public function save()
    {
        $sql = "INSERT INTO contents (course_id, type) VALUES (?, 'video')";
        $params = [
            $this->courseId
        ];

        $this->db->query($sql, $params);

        $contentId = $this->db->lastInsertId();

        $sql = "INSERT INTO video_contents (content_id, video_url, duration) VALUES (?, ?, ?)";
        $params = [
            $contentId,
            $this->vidUrl,
            $this->duration
        ];

        $this->db->query($sql, $params);

        return $this->db->lastInsertId();
    }

    public function display($courseId)
    {
        $sql = "SELECT title , DESCRIPTION , TYPE , video_url FROM courses
        INNER JOIN contents ON courses.id = contents.course_id
        INNER JOIN video_contents ON contents.id = video_contents.content_id
        WHERE courses.id = ?";

        $result = $this->db->fetch($sql, [$courseId]);
        return $result;
    }
}