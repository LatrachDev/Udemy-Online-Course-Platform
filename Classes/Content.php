<?php
    abstract class Content
    {
        protected $db;
        protected $courseId;

        public function __construct($db, $courseId)
        {
            $this->db = $db;
            $this->courseId = $courseId;
        }
    
        public function setCourseId($courseId)
        {
            $this->courseId = $courseId;
        }
    
        abstract public function save();
        abstract public function display($courseId);
    }
?>