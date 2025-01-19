<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: errors/403.php');
        exit;
    }

    require_once '../../includes/functions.php';
    

    $tags = fetchAllTags($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Content Management - YouDemy</title>
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
                    <a href="dashboard.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        Dashboard
                    </a>
                    <a href="usermanagement.php" class="block px-4 py-2 text-indigo-200 hover:bg-indigo-600 hover:text-white rounded-lg">
                        User Management
                    </a>
                    <a href="contentmanagement.php" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white">
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

            <!-- Content Management Content -->
            <main class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Content Management</h1>

                <!-- Courses Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Courses</h2>
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
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Categories Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Categories</h2>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">
                                Web Development
                                <button class="ml-2 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">
                                Data Science
                                <button class="ml-2 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">
                                Graphic Design
                                <button class="ml-2 hover:text-indigo-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tags Section -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">Tags</h2>
                    </div>
                    <div class="p-6">
                        
                        <!-- add tags -->
                        <form action="addTags.php" method="POST">
                            <div class="mb-6">
                                <label for="tagsAdd" class="block text-sm font-medium text-gray-700 mb-2">Add Multiple Tags</label>
                                <div class="flex gap-4">
                                    <input type="text" id="tagsAdd" name="tags"
                                        class="p-2 border flex-1 rounded-lg border-gray-300 focus:border-indigo-600 focus:ring-indigo-600"
                                        placeholder="Enter tags separated by commas (e.g., JavaScript, Python, Web Development)">
                                    <button type="submit"
                                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors">
                                        Add Tags
                                    </button>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Tags will be automatically converted to lowercase and trimmed</p>
                            </div>
                        </form>

                        <!-- Existing Tags -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Existing Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach($tags as $tag) : ?>

                                    <form action="deleteTags.php" method="POST" class="inline">
                                        <input type="hidden" name="tag_id" value="<?= $tag['id'] ?>">
                                        <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-600 rounded-full text-sm">
                                            <?= $tag['name'] ?>
                                            <button type="submit" class="ml-2 hover:text-indigo-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </span>
                                    </form>

                                <?php endforeach ?>
                                                           
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>