<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') 
    {
        header('Location: /../../errors/403.php');
        exit;
    }

    require_once '../../Config/Database.php';
    require_once '../../Classes/Enrollment.php';

    $db = new Database();
    $conn = $db->getConnection();

    $enrollment = new Enrollment($conn);
    $studentId = $_SESSION['user_id'];

    $enrolledCourses = $enrollment->getEnrolledCourses($studentId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <header class="bg-white shadow">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="#" class="text-2xl font-bold text-blue-600">Youdemy</a>
            <nav class="space-x-6">
                <a href="student.php" class="hover:text-blue-600">Home</a> 
                <a href="my_course.php" class="hover:text-blue-600">My courses</a> 
                <a href="/../logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-blue-700">Logout</a>
            </nav>
        </div>
    </header>

    <section id="my-courses" class="py-16">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold mb-8">My Courses</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-5">
                <?php foreach($enrolledCourses as $course) : ?>
                    <div class="bg-white shadow-md rounded overflow-hidden">
                        <img src="<?= $course['thumbnail_url'] ?>" alt="Course Image" class="w-full">
                        <div class="p-4">
                            <h3 class="text-xl font-bold mb-2"><?= $course['title'] ?></h3>
                            <p class="text-gray-600 mb-4"><?= $course['description'] ?></p>
                            <a href="course_details.php?course_id=<?= $course['id'] ?>" class="text-blue-600 font-medium hover:underline">Continue Learning</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</body>
</html>