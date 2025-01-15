<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - Youdemy</title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <script src="../../Public/assets/JavaScript/tailwind.js"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Sign Up Section -->
  <section class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded px-8 py-10 max-w-md w-full">
      <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Create an Account</h2>
      <form action="/signup" method="POST">
        <!-- Name Field -->
        <div class="mb-4">
          <label for="name" class="block text-gray-700 font-medium mb-2">Full Name</label>
          <input type="text" id="name" name="name" placeholder="Your Name" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Email Field -->
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
          <input type="email" id="email" name="email" placeholder="example@example.com" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Password Field -->
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
          <input type="password" id="password" name="password" placeholder="* * * * * * * *" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Role Selection -->
        <div class="mb-4">
          <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
          <select id="role" name="role" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="etudiant">Student</option>
            <option value="enseignant">Teacher</option>
          </select>
        </div>
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Sign Up</button>
      </form>
      <p class="text-gray-600 text-center mt-4">
        Already have an account? 
        <a href="login.html" class="text-blue-600 font-medium hover:underline">Login</a>
      </p>
    </div>
  </section>

</body>
</html>
