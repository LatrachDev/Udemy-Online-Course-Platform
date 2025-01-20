<?php

require_once 'Content.php';
class DocumentContent extends Content
{
    private $documentUrl;

    public function __construct($db, $courseId, $documentUrl)
    {
        parent::__construct($db, $courseId);
        $this->documentUrl = $documentUrl;
    }

    public function save()
    {
        $stmt = $this->db->prepare("INSERT INTO course_content (course_id, content_type, content_url) VALUES (?, 'document', ?)");
        $stmt->execute([$this->courseId, $this->documentUrl]);
    }

    public function display($courseId)
    {
        $stmt = $this->db->prepare("SELECT content_url FROM course_content WHERE course_id = ? AND content_type = 'document'");
        $stmt->execute([$courseId]);
        $documentUrl = $stmt->fetchColumn();

        return "<a href='$documentUrl' target='_blank'>Download Document</a>";
    }
}