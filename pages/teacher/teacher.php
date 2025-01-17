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
                    <a href="#" class="text-2xl font-bold text-white">Youdemy</a>
                </div>
            </div>
            <nav class="mt-6">
                <div class="px-4 space-y-2">
                    <a href="teacher_dashboard.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        Dashboard
                    </a>
                    <a href="teacher_courses.php" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white">
                        Course Management
                    </a>
                    <a href="teacher_statistics.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        Statistics
                    </a>
                    <a href="logout.php" class="px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg flex items-center gap-2">
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
                            <span class="text-gray-700">Teacher</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Teacher Dashboard Content -->
            <main class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Course Management</h1>

                <!-- Add New Course Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Add New Course</h2>
                    </div>
                    <div class="p-6">
                        <form action="add_course.php" method="POST" enctype="multipart/form-data">
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

                                <!-- Content (Video or Document) -->
                                <div>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Content (Video or Document)</label>
                                    <input type="file" id="content" name="content" accept="video/*, .pdf, .doc, .docx" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                </div>

                                <!-- Tags (Select Existing Tags) -->
                                <div>
                                    <label for="tags" class="block text-sm font-medium text-gray-700">Tags</label>
                                    <select id="tags" name="tags[]" multiple
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                        <?php
                                        // Example PHP code to fetch existing tags from the database
                                        $tags = ["JavaScript", "Python", "Web Development", "Data Science", "Frontend", "Backend"];
                                        foreach ($tags as $tag) {
                                            echo "<option value='$tag'>$tag</option>";
                                        }
                                        ?>
                                    </select>
                                    <p class="mt-1 text-sm text-gray-500">Hold <kbd>Ctrl</kbd> (Windows) or <kbd>Command</kbd> (Mac) to select multiple tags.</p>
                                </div>

                                <!-- Category -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                    <select id="category" name="category" required
                                        class="mt-1 p-2 w-full border rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600">
                                        <option value="Web Development">Web Development</option>
                                        <option value="Data Science">Data Science</option>
                                        <option value="Graphic Design">Graphic Design</option>
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
                                        <th class="p-4 text-gray-600">Category</th>
                                        <th class="p-4 text-gray-600">Tags</th>
                                        <th class="p-4 text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Course 1 -->
                                    <tr class="border-t">
                                        <td class="p-4 text-gray-800">Advanced JavaScript Masterclass</td>
                                        <td class="p-4 text-gray-800">Web Development</td>
                                        <td class="p-4 text-gray-800">
                                            <span class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">JavaScript</span>
                                            <span class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">Frontend</span>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex gap-2">
                                                <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Edit</button>
                                                <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                                                <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">Enrollments</button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Course 2 -->
                                    <tr class="border-t">
                                        <td class="p-4 text-gray-800">Python for Data Science</td>
                                        <td class="p-4 text-gray-800">Data Science</td>
                                        <td class="p-4 text-gray-800">
                                            <span class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">Python</span>
                                            <span class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">Data Analysis</span>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex gap-2">
                                                <button class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Edit</button>
                                                <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                                                <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">Enrollments</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistics Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Statistics</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Number of Students -->
                            <div class="bg-indigo-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-indigo-600">Number of Enrolled Students</h3>
                                <p class="text-3xl font-bold text-gray-800 mt-2">1,234</p>
                            </div>

                            <!-- Number of Courses -->
                            <div class="bg-indigo-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-indigo-600">Number of Courses</h3>
                                <p class="text-3xl font-bold text-gray-800 mt-2">15</p>
                            </div>

                            <!-- Other Statistics -->
                            <div class="bg-indigo-50 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold text-indigo-600">Other Statistics</h3>
                                <p class="text-gray-800 mt-2">Completion Rate: 85%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>