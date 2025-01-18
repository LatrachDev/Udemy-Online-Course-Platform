<?php
    session_start();

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: errors/403.php');
        exit;
    }

    require_once '../../includes/functions.php';

    // for update the status of the user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['new_status'])) 
    {
        $user_id = $_POST['user_id'];
        $new_status = $_POST['new_status'];

        if (in_array($new_status, ['active', 'banned'])) 
        {
            $query = "UPDATE users SET status = :status WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':status', $new_status);
            $stmt->bindParam(':id', $user_id);

            if ($stmt->execute()) 
            {
                header('Location: usermanagement.php');
                exit;
            }
        }
    }

    // for remove the user
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) 
    {
        $delete_user = $_POST['delete_user'];

        if (!empty($delete_user)) 
        {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $delete_user);

            if ($stmt->execute()) 
            {
                header('Location: usermanagement.php');
                exit;
            }
        }
    }
    

    $users = fetchAllUsers($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - YouDemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    <a href="usermanagement.php" class="block px-4 py-2 rounded-lg bg-indigo-600 text-white">
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

            <!-- User Management Content -->
            <main class="p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">User Management</h1>

                <!-- User Table -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b">
                        <h2 class="text-xl font-bold text-gray-800">User List</h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left bg-gray-50">
                                        <th class="p-4 text-gray-600">Name</th>
                                        <th class="p-4 text-gray-600">Email</th>
                                        <th class="p-4 text-gray-600">Role</th>
                                        <th class="p-4 text-gray-600">Status</th>
                                        <th class="p-4 text-gray-600">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach($users as $user) : ?>

                                        <tr class="border-t">
                                            <td class="p-4 text-gray-800"><?= $user['name'] ?></td>
                                            <td class="p-4 text-gray-800"><?= $user['email'] ?></td>
                                            <td class="p-4 text-gray-800"><?= $user['role'] ?></td>
                                            <td class="p-4">
                                                <span class="px-2 py-1 <?= $user['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> rounded-full text-sm">
                                                    <?= $user['status'] ?>
                                                </span>
                                            </td>
                                            <td class="p-4">
                                                
                                                <form action="usermanagement.php" method="POST" class="inline">
                                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                                    <input type="hidden" name="new_status" value="<?= $user['status'] === 'active' ? 'banned' : 'active' ?>">
                                                    <button type="submit" class="px-3 py-1 <?= $user['status'] === 'active' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' ?> rounded-full hover:bg-red-200 transition duration-300">
                                                        <?= $user['status'] === 'active' ? 'Suspend' : 'Activate' ?>
                                                    </button>
                                                </form>

                                                <form action="usermanagement.php" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    <input type="hidden" name="delete_user" value="<?= $user['id'] ?>">
                                                    <button type="submit" class="p-1 text-gray-500 hover:text-red-500 rounded-lg transition duration-300">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </td>
                                            
                                        </tr>

                                    <?php endforeach ?>
                                                                        
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