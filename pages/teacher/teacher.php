<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
        header('Location: /../errors/403.php');
        exit;
    }

    require_once '../../includes/functions.php';
    require_once '../../Config/Database.php';
    require_once '../../Classes/Tags.php';
    require_once '../../Classes/Category.php';
        
    $tags = new Tags($conn);
    $allTags = $tags->fetchAllTags();

    $categories = new Category($conn); 
    $allCategories = $categories->fetchAllCategories();

    $categories = fetchAllCategories($conn);

    $teacherStatus = $_SESSION['status'];

    
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
                    <a href="teacher.php" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white">
                        Dashboard
                    </a>
                    <a href="teacher_courses.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
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

            <?php if ($teacherStatus === 'pending') : ?>
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        
                <p class="font-bold">Waiting for Approval</p>
                    <p>Your request to become a teacher is pending. Please wait for admin approval.</p>
                </div>
            
            <?php else : ?>

                <h1 class="text-2xl font-bold text-gray-800 mb-6">Course Management</h1>

                <!-- Add New Course Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Add New Course</h2>
                    </div>
                    <div class="p-6">
                        <form action="addCourse.php" method="POST" enctype="multipart/form-data">
                            <div class="space-y-4">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Course Title</label>
                                    <input type="text" id="title" name="title" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                </div>

                                <!-- Description -->
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" rows="3" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"></textarea>
                                </div>

                                <!-- Content URL -->
                                <div>
                                    <label for="content_url" class="block text-sm font-medium text-gray-700">Content URL</label>
                                    <input type="url" id="content_url" name="content_url" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="Enter the URL for the content">
                                </div>

                                <!-- Thumbnail URL -->
                                <div>
                                    <label for="thumbnail_url" class="block text-sm font-medium text-gray-700">Thumbnail URL</label>
                                    <input type="url" id="thumbnail_url" name="thumbnail_url" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="Enter the URL for the thumbnail">
                                </div>

                                <!-- Content Type -->
                                <div>
                                    <label for="content_type" class="block text-sm font-medium text-gray-700">Content Type</label>
                                    <select id="content_type" name="content_type" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                        <option value="video">Video</option>
                                        <option value="document">Document</option>
                                    </select>
                                </div>

                                <!-- Tags (Select Existing Tags) -->
                                <div>
                                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                                    <select id="tags" name="tags[]" multiple
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                        <?php foreach ($allTags as $tag) : ?>
                                            <option value="<?= $tag['id'] ?>"> <?= $tag['name'] ?> </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Hold <kbd>Ctrl</kbd> (Windows) or <kbd>Command</kbd> (Mac) to select multiple tags.</p>
                                </div>

                                <!-- Category -->
                                <div>
                                    <for="category" class="block text-sm font-medium text-gray-700">Category</for=>
                                    <select id="category" name="category" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                        
                                        <?php foreach ($categories as $category) : ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                        <?php endforeach; ?>
                        
                                    </select>
                                </div>

                                <!-- Submit Button -->
                                <div>
                                    <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                                        Add Course
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            <?php endif; ?>
            
            </main>
        </div>
    </div>
</body>

</html>