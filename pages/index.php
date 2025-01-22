<?php

    require_once '../Config/Database.php';
    require_once '../Classes/Enrollment.php';

    $db = new Database();
    $conn = $db->getConnection();


    $stmt = $conn->prepare("
        SELECT 
            course.id,
            course.title,
            course.description,
            course.thumbnail_url,
            course.content_type,
            category.name AS category_name,
            users.name AS teacher_name
        FROM course
        JOIN category ON course.category_id = category.id
        JOIN users ON course.teacher_id = users.id
        LEFT JOIN enrollments ON course.id = enrollments.course_id AND enrollments.user_id = :user_id
        WHERE enrollments.user_id IS NULL
    ");
    $stmt->bindParam(":user_id", $student_id);
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy - Online Learning Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <header class="bg-white shadow">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <a href="#" class="text-2xl font-bold text-blue-600">Youdemy</a>
        <nav class="space-x-6">           
            <a href="signup.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Signup</a>
        </nav>
        </div>
    </header>

    <section class="bg-blue-600 text-white py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome To Youdemy</h1>
            <p class="text-lg mb-6">Learn from the best instructors anytime, anywhere.</p>
            <a href="login.php" class="bg-white text-blue-600 px-6 py-3 rounded font-medium shadow-md hover:bg-gray-200">Get started</a>
        </div>
    </section>

    <section id="courses" class="py-16">
        <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8">Explore Popular Courses</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-5">

        <?php foreach($courses as $course) : ?>
            
            <!-- Course Card 1 -->
            <div class="bg-white shadow-md rounded overflow-hidden">
                <img src="<?= $course['thumbnail_url'] ?>" alt="Course Image" class="w-full">
                <div class="p-4">
                    <h3 class="text-xl font-bold mb-2"><?= $course['title'] ?></h3>
                    <p class="text-gray-600 mb-4"><?= $course['description'] ?></p>
                    
                </div>
            </div>
        
        <?php endforeach; ?>
            
        </div>
        </div>
    </section>

    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="container mx-auto text-center">
        <p>&copy; 2025 Youdemy. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
