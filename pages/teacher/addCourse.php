<?php 
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
        header('Location: /../errors/403.php');
        exit;
    }

    require __DIR__ . '/../../Config/Database.php';
    require __DIR__ . '/../../Classes/Course.php';
    require __DIR__ . '/../../Classes/VideoContent.php';
    require __DIR__ . '/../../Classes/DocumentContent.php';

    $db = new Database();
    $conn = $db->getConnection();

    $title = $_POST['title'];
    $description = $_POST['description'];
    $contentUrl = $_POST['content_url'];
    $thumbnailUrl = $_POST['thumbnail_url'];
    $contentType = $_POST['content_type'];
    $categoryId = $_POST['category'];
    $teacherId = $_SESSION['user_id'];
    $tags = $_POST['tags'];

    // $stmt = $conn->prepare("INSERT INTO course (title, description, category_id, teacher_id) VALUES (?, ?, ?, ?)");
    $stmt = $conn->prepare("
        INSERT INTO course (title, description, content_url, thumbnail_url, content_type, category_id, teacher_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$title, $description, $contentUrl, $thumbnailUrl, $contentType, $categoryId, $teacherId]);
    // $stmt->execute([$title, $description, $categoryId, $teacherId]);
    $courseId = $conn->lastInsertId(); 

    if ($contentType === 'video') 
    {
        $content = new VideoContent($conn, $courseId, $contentUrl);
    }
    else 
    {
        $content = new DocumentContent($conn, $courseId, $contentUrl);
    }
    $content->save();
    
    if (!empty($tags))
    {
        foreach ($tags as $tagId) 
        {
            $stmt = $conn->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
            $stmt->execute([$courseId, $tagId]);
        }
    }
    else
    {
        die("Error: At least one tag must be selected.");
    }
    
    header('Location: teacher_courses.php');
    exit;

?>