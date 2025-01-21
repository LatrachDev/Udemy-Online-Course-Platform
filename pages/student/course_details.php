<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header('Location: /../../errors/403.php');
    exit;
}

require_once '../../Config/Database.php';
require_once '../../Classes/Course.php';
require_once '../../Classes/Enrollment.php';

$db = new Database();
$conn = $db->getConnection();

// Check if the course ID is provided in the URL
if (!isset($_GET['course_id'])) {
    header('Location: my_course.php');
    exit;
}

$courseId = $_GET['course_id'];

// Fetch course details
$course = new Course($conn);
$courseDetails = $course->getCourseById($courseId);

if (!$courseDetails) {
    header('Location: my_course.php');
    exit;
}

// Fetch enrolled courses to verify the student is enrolled in this course
$enrollment = new Enrollment($conn);
$studentId = $_SESSION['user_id'];

if (!$enrollment->isEnrolled($studentId, $courseId)) {
    header('Location: my_course.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $courseDetails['title'] ?> - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .course-thumbnail {
            height: 400px;
            object-fit: cover;
        }
        .video-preview {
            width: 100%;
            max-width: 400px;
            height: 250px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .document-preview {
            width: 100%;
            max-width: 400px;
            height: 250px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    <!-- Header -->
    <header class="bg-white shadow-lg">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="#" class="text-2xl font-bold text-blue-600 hover:text-blue-700 transition-colors">Youdemy</a>
            <nav class="space-x-6">
                <a href="student.php" class="text-gray-700 hover:text-blue-600 transition-colors">Home</a> 
                <a href="my_course.php" class="text-gray-700 hover:text-blue-600 transition-colors">My Courses</a> 
                <a href="/../logout.php" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">Logout</a>
            </nav>
        </div>
    </header>

    <!-- Top Section: Thumbnail and Course Details -->
    <section class="relative">
        <!-- Thumbnail -->
        <img src="<?= $courseDetails['thumbnail_url'] ?>" alt="Course Thumbnail" class="w-full course-thumbnail">

        <!-- Course Details Overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="text-center text-white max-w-2xl px-4">
                <h1 class="text-4xl font-bold mb-4"><?= $courseDetails['title'] ?></h1>
                <p class="text-lg"><?= $courseDetails['description'] ?></p>
            </div>
        </div>
    </section>

    <!-- Bottom Section: Video or Document Preview -->
    <section class="py-12 bg-gray-100">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Course Preview</h2>
            <div class="flex justify-center">
                <?php if ($courseDetails['content_type'] === 'video') : ?>
                    <!-- Video Preview -->
                    <div class="video-preview">
                        <video controls class="w-full h-full rounded-lg">
                            <source src="<?= $courseDetails['content_url'] ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <?php elseif ($courseDetails['content_type'] === 'document') : ?>
                    <!-- Document Preview -->
                    <div class="document-preview">
                        <iframe src="<?= $courseDetails['content_url'] ?>" class="w-full h-full rounded-lg" frameborder="0"></iframe>
                    </div>
                <?php else : ?>
                    <p class="text-gray-600 text-lg">No content available for this course.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-8">
        <div class="container mx-auto text-center">
            <p class="text-sm">&copy; 2025 Youdemy. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>