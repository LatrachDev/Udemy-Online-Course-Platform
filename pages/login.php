<?php
  require __DIR__ . '../includes/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Youdemy</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <section class="flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md rounded px-8 py-10 max-w-md w-full">
      <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Login to Your Account</h2>
      
      <?php if (!empty($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <form action="login.php" method="POST">
 
        <div class="mb-4">
          <label for="email" class="block text-gray-700 font-medium mb-2">Email Address</label>
          <input type="email" id="email" name="email" placeholder="example@example.com" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
  
        <div class="mb-4">
          <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
          <input type="password" id="password" name="password" placeholder="••••••••" required
            class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
      
        <button type="submit" name="login" class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Login</button>
      </form>

      <p class="text-gray-600 text-center mt-4">
        Don't have an account? 
        <a href="signup.php" class="text-blue-600 font-medium hover:underline">Sign Up</a>
      </p>

    </div>
  </section>

</body>
</html>