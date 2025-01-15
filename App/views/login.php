<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Youdemy</title>
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <script src="../../Public/assets/JavaScript/tailwind.js"></script>

</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Login Section -->
  <section class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded px-8 py-10 max-w-md w-full">
      <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login to Your Account</h2>
      <form action="/login" method="POST">
        <!-- Email Field -->
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
          <input type="email" id="email" name="email" placeholder="example@example.com" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Password Field -->
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
          <input type="password" id="password" name="password" placeholder="••••••••" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</button>
      </form>
      <p class="text-gray-600 text-center mt-4">
        Don't have an account? 
        <a href="signup.html" class="text-blue-600 font-medium hover:underline">Sign Up</a>
      </p>
    </div>
  </section>

</body>
</html>
