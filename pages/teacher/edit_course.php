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

if (isset($_GET['course_id'])) 
{
    $course_id = $_GET['course_id'];
    $stmt = $conn->prepare("SELECT * FROM course WHERE id = ?");
    $stmt->execute([$course_id]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$course) 
    {
        die("Course not found.");
    }
} 
else
{
    die("Invalid request.");
}

$categories = $conn->query("SELECT * FROM category")->fetchAll(PDO::FETCH_ASSOC);
$tags = $conn->query("SELECT * FROM tags")->fetchAll(PDO::FETCH_ASSOC);
$content_types = $conn->query("SELECT DISTINCT content_type FROM course")->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT tag_id FROM course_tags WHERE course_id = ?");
$stmt->execute([$course_id]);
$selected_tags = $stmt->fetchAll(PDO::FETCH_COLUMN);

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $title = $_POST['title'];
    $description = $_POST['description'];
    $thumbnail_url = $_POST['thumbnail_url'];
    $content = $_POST['content_url'];
    $category_id = $_POST['category_id'];
    $content_type = $_POST['content_type'];
    $tags = $_POST['tags'] ?? [];

    $stmt = $conn->prepare("
        UPDATE course 
        SET title = ?, description = ?, thumbnail_url = ?, content_url = ?, category_id = ?, content_type = ?
        WHERE id = ?
    ");
    $stmt->execute([$title, $description, $thumbnail_url, $content, $category_id, $content_type, $course_id]);

    $conn->prepare("DELETE FROM course_tags WHERE course_id = ?")->execute([$course_id]);
    if (!empty($tags)) 
    {
        $stmt = $conn->prepare("INSERT INTO course_tags (course_id, tag_id) VALUES (?, ?)");
        foreach ($tags as $tag_id) 
        {
            $stmt->execute([$course_id, $tag_id]);
        }
    }

    header('Location: teacher_courses.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - YouDemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Edit Course</h1>
        <form method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <!-- Title -->
            <div class="mb-4">
                <label for="title" class="block text-gray-700">Title</label>
                <input type="text" name="title" id="title" value="<?= htmlspecialchars($course['title']) ?>" class="w-full p-2 border rounded-lg" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700">Description</label>
                <textarea name="description" id="description" class="w-full p-2 border rounded-lg" required><?= htmlspecialchars($course['description']) ?></textarea>
            </div>

            <!-- Thumbnail URL -->
            <div class="mb-4">
                <label for="thumbnail_url" class="block text-gray-700">Thumbnail URL</label>
                <input type="url" name="thumbnail_url" id="thumbnail_url" value="<?= htmlspecialchars($course['thumbnail_url']) ?>" class="w-full p-2 border rounded-lg" required>
            </div>

            <!-- Content URL -->
            <div class="mb-4">
                <label for="content_url" class="block text-gray-700">Content URL</label>
                <input type="url" name="content_url" id="content_url" value="<?= isset($course['content_url']) ? htmlspecialchars($course['content_url']) : '' ?>" class="w-full p-2 border rounded-lg" required>
            </div>

            <!-- Category Dropdown -->
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700">Category</label>
                <select name="category_id" id="category_id" class="w-full p-2 border rounded-lg" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $course['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Content Type Dropdown -->
            <div class="mb-4">
                <label for="content_type" class="block text-gray-700">Content Type</label>
                <select name="content_type" id="content_type" class="w-full p-2 border rounded-lg" required>
                    <?php foreach ($content_types as $type) : ?>
                        <option value="<?= $type['content_type'] ?>" <?= $type['content_type'] == $course['content_type'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($type['content_type']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Tags Checkboxes -->
            <div class="mb-4">
                <label class="block text-gray-700">Tags</label>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($tags as $tag) : ?>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" 
                                <?= in_array($tag['id'], $selected_tags) ? 'checked' : '' ?> 
                                class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 text-gray-700"><?= htmlspecialchars($tag['name']) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update Course</button>
        </form>
    </div>
</body>
</html>