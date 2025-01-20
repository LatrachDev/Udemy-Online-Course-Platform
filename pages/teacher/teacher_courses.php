<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') 
    {
        header('Location: /../errors/403.php');
        exit;
    }

    require_once '../../Config/Database.php';
    $db = new Database();
    $conn = $db->getConnection();

    $teacherId = $_SESSION['user_id'];

    $stmt = $conn->prepare("
            SELECT 
            course.id AS course_id,
            course.title,
            course.description,
            course.content_type,
            category.name AS category_name,
            GROUP_CONCAT(CONCAT('#', tags.name) SEPARATOR ', ') AS tag_names,
            GROUP_CONCAT(users.name SEPARATOR ', ') AS enrolled_users
        FROM course
        JOIN category ON course.category_id = category.id
        LEFT JOIN course_tags ON course.id = course_tags.course_id
        LEFT JOIN tags ON course_tags.tag_id = tags.id
        LEFT JOIN enrollments ON course.id = enrollments.course_id
        LEFT JOIN users ON enrollments.user_id = users.id
        WHERE course.teacher_id = ?
        GROUP BY course.id
    ");

    $stmt->execute([$teacherId]);
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - YouDemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-indigo-700 shadow-lg hidden lg:block">
            <div class="p-6">
                <div class="text-2xl font-bold text-white">
                    <a href="teacher.php" class="text-2xl font-bold text-white">Youdemy</a>
                </div>
            </div>
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="teacher.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        Dashboard
                    </a>
                    <a href="teacher_courses.php" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white">
                        Course Management
                    </a>
                    <a href="teacher_statistics.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        Statistics
                    </a>
                    <a href="/../../logout.php" class="px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <button class="lg:hidden">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-4">
                        <button class="relative">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                        </button>
                        <div class="flex items-center gap-2">
                            <div class="w-10 h-10 rounded-full shadow-md border flex justify-center items-center font-bold bg-indigo-600 text-white">T</div>
                            <span class="text-gray-700"><?= isset($_SESSION['name']) ? $_SESSION['name'] : 'Teacher' ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Teacher Dashboard Content -->
            <main class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Course Management</h1>

                <!-- Manage Courses Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Manage Courses</h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left bg-gray-50">
                                        <th class="p-4 text-gray-600">Title</th>
                                        <th class="p-4 text-gray-600">Description</th>
                                        <th class="p-4 text-gray-600">Type</th>
                                        <th class="p-4 text-gray-600">Category</th>
                                        <th class="p-4 text-gray-600">Tags</th>
                                        <th class="p-4 text-gray-600">Enrollments</th>
                                        <th class="p-4 text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($courses as $course) : ?>
                                    <!-- Course 1 -->
                                    <tr class="border-t">
                                        <td class="p-4 text-gray-800"><?= $course['title'] ?></td>
                                        <td class="p-4 text-gray-800"><?= $course['description'] ?></td>
                                        <td class="p-4 text-gray-800"><?= $course['content_type'] ?></td>
                                        <td class="p-4 text-gray-800"><?= $course['category_name'] ?></td>
                                        <td class="p-4 text-gray-800">
                                            <span class="inline-flex items-center px-2 my-1 py-1 bg-indigo-100 text-indigo-600  text-sm"><?= !empty($course['tag_names']) ? $course['tag_names'] : 'No tags' ?></span>
                                        </td>
                                        
                                        <td class="p-4 text-gray-800">
                                            <?php if (!empty($course['enrolled_users'])) : ?>
                                                <?= htmlspecialchars($course['enrolled_users']) ?>
                                            <?php else : ?>
                                                <span class="text-gray-500">No enrollments</span>
                                            <?php endif; ?>
                                        </td>
                                        
                                        
                                        <td class="p-4">
                                            <div class="flex gap-2">
                                                <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Edit</button>
                                                <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                                    

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>

</html>