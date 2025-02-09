<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: /../errors/403.php');
        exit;
    }

    require_once '../../includes/functions.php';
    require_once '../../Config/Database.php';
    require_once '../../Classes/User.php';

    $db = new Database();
    $conn = $db->getConnection();

    $user = new User($conn);
    
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['teacher_id'], $_POST['action'])) 
    {
        $teacher_id = $_POST['teacher_id'];
        $action = $_POST['action'];
        
        if ($action === 'approve') 
        {
            
            $query = "UPDATE users SET status = 'active' WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $teacher_id);
            
            if ($stmt->execute()) {
                header('Location: dashboard.php');
                exit;
            } 
        } 
        elseif ($action === 'reject') 
        {
            
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $teacher_id);
            
            if ($stmt->execute()) 
            {
                header('Location: usermanagement.php');
                exit;
            } 
        }
    }

    $stmt = $conn->prepare("
        SELECT 
            course.id AS course_id,
            course.title,
            COUNT(enrollments.id) AS enrollment_count
        FROM course
        LEFT JOIN enrollments ON course.id = enrollments.course_id
        GROUP BY course.id
        ORDER BY enrollment_count DESC
        LIMIT 1
    ");
    $stmt->execute();
    $mostPopularCourse = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $topTeachers = $user->getTopTeachers();
    $totalCourses = getTotalCourses($conn);
    $teachers = fetchAllTeachers($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouDemy Admin Dashboard</title>
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
                    <a href="#" class="text-2xl font-bold text-white">Youdemy</a>
                </div>
            </div>
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="dashboard.php" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white">
                        Dashboard
                    </a>
                    <a href="usermanagement.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        User Management
                    </a>
                    <a href="contentmanagement.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        Content Management
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
                            <div class="w-10 h-10 rounded-full shadow-md border flex justify-center items-center font-bold bg-indigo-600 text-white">A</div>
                            <span class="text-gray-700">Admin</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Dashboard Content -->
            <main class="p-6">
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Total Courses -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-500">Total Courses</h3>
                            <span class="text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800"><?= $totalCourses ?></p>
                    </div>

                    <!-- Course with Most Students -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-500">Most Popular Course</h3>
                            <span class="text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </span>
                        </div>
                        <p class="text-2xl font-bold text-gray-800"><?= $mostPopularCourse['title'] ?></p>
                        <p class="text-sm text-gray-500"><?= $mostPopularCourse['enrollment_count'] ?>  enrollments.</p>
                    </div>

                    <!-- Top 3 Teachers -->
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-gray-500">Top 3 Teachers</h3>
                            <span class="text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </span>
                        </div>
                        <div class="space-y-2">
                            <?php if (empty($topTeachers)) : ?>
                                <p class="text-gray-800">No top teachers found.</p>
                            <?php else : ?>
                                <?php foreach ($topTeachers as $teacher) : ?>
                                    <p class="text-gray-800">
                                        <?= $teacher['name'] ?> (<?= $teacher['student_count'] ?> students)
                                    </p>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <!-- Teacher Validation Section -->
                <div class="bg-white rounded-xl shadow-sm mb-6 border border-gray-100">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Pending Teacher Validations</h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left bg-gray-50">
                                        <th class="p-4 text-gray-600">Name</th>
                                        <th class="p-4 text-gray-600">Email</th>
                                        <th class="p-4 text-gray-600">Position</th>
                                        <th class="p-4 text-gray-600">Status</th>
                                        <th class="p-4 text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php if (empty($teachers)) : ?>
                                    <tr>
                                        <td colspan="5" class="p-4 text-center text-gray-800">No pending teacher requests.</td>
                                    </tr>
                                    <?php else : ?>
                                        <?php foreach($teachers as $teacher) : ?>

                                        <tr class="border-t">
                                            <td class="p-4 text-gray-800"><?= $teacher['name'] ?></td>
                                            <td class="p-4 text-gray-800"><?= $teacher['email'] ?></td>
                                            <td class="p-4 text-gray-800"><?= $teacher['role'] ?></td>
                                            <td class="p-4">
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm"><?= $teacher['status'] ?> </span>
                                            </td>

                                            <td class="p-4">
                                                <div class="flex gap-2">

                                                    <form action="dashboard.php" method="POST" class="inline">
                                                        <input type="hidden" name="teacher_id" value="<?= $teacher['id'] ?>">
                                                        <input type="hidden" name="action" value="approve">
                                                        <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                                            Approve
                                                        </button>
                                                    </form>

                                                    <form action="dashboard.php" method="POST" class="inline">
                                                        <input type="hidden" name="teacher_id" value="<?= $teacher['id'] ?>">
                                                        <input type="hidden" name="action" value="reject">
                                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                                            Reject
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                
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