<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Youdemy - Online Learning Platform</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <a href="#" class="text-2xl font-bold text-blue-600">Youdemy</a>
        <nav class="space-x-6">
            <a href="#about" class="hover:text-blue-600">About</a>
            <a href="#courses" class="hover:text-blue-600">Courses</a>
            <a href="#contact" class="hover:text-blue-600">Contact</a>
            <a href="signup.html" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Sign Up</a>
        </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-16">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-bold mb-4">Welcome to Youdemy</h1>
            <p class="text-lg mb-6">Learn from the best instructors anytime, anywhere.</p>
            <a href="signup.html" class="bg-white text-blue-600 px-6 py-3 rounded font-medium shadow-md hover:bg-gray-200">Get Started</a>
        </div>
    </section>

    <!-- Courses Preview Section -->
    <section id="courses" class="py-16">
        <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold mb-8">Explore Popular Courses</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-5">
            <!-- Course Card 1 -->
            <div class="bg-white shadow-md rounded overflow-hidden">
            <img src="https://placehold.co/600x400@3x.png" alt="Course Image" class="w-full">
            <div class="p-4">
                <h3 class="text-xl font-bold mb-2">Web Development</h3>
                <p class="text-gray-600 mb-4">Learn HTML, CSS, and JavaScript to build modern websites.</p>
                <a href="#" class="text-blue-600 font-medium hover:underline">Learn More</a>
            </div>
            </div>
            <!-- Course Card 2 -->
            <div class="bg-white shadow-md rounded overflow-hidden">
            <img src="https://placehold.co/600x400@3x.png" alt="Course Image" class="w-full">
            <div class="p-4">
                <h3 class="text-xl font-bold mb-2">Data Science</h3>
                <p class="text-gray-600 mb-4">Master Python and machine learning techniques.</p>
                <a href="#" class="text-blue-600 font-medium hover:underline">Learn More</a>
            </div>
            </div>
            <!-- Course Card 3 -->
            <div class="bg-white shadow-md rounded overflow-hidden">
            <img src="https://placehold.co/600x400@3x.png" alt="Course Image" class="w-full">
            <div class="p-4">
                <h3 class="text-xl font-bold mb-2">Graphic Design</h3>
                <p class="text-gray-600 mb-4">Explore tools like Photoshop and Illustrator to create stunning designs.</p>
                <a href="#" class="text-blue-600 font-medium hover:underline">Learn More</a>
            </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="container mx-auto text-center">
        <p>&copy; 2025 Youdemy. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
