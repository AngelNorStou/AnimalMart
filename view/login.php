<?php
require_once '../config/database.php';
require_once '../model/UserModel.php';
require_once '../controller/UserController.php';

session_start();

// Create a database connection
$pdo = Database::getConnection();

// Pass PDO to the model
$userModel = new UserModel($pdo);

// Pass the model to the controller
$userController = new UserController($userModel,$pdo);

$loginResult = null;

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginResult = $userController->verifyLogin($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to AnimalMart!</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center">
        <div class="flex space-x-4">
            <a href="Home.php" class="hover:text-blue-300">Home</a>
            <a href="services.php?page=1" class="hover:text-blue-300">Services</a>
            <a href="contact.php" class="hover:text-blue-300">Contact</a>
        </div>
        <div class="text-xl font-bold">Welcome To AnimalMart!</div>
        <div class="flex space-x-4">
            <a href="login.php" class="text-white underline">Login</a>
            <a href="signup.php" class="text-red-500 hover:text-red-700">Sign Up</a>
        </div>
    </nav>

    <!-- Login Form -->
    <main class="flex-grow flex justify-center items-center mt-12">
        <form action="login.php" method="POST" class="bg-white p-10 rounded-lg shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold text-center mb-6 text-blue-900">Welcome Back!</h1>

            <!-- Email -->
            <div class="mb-4">
                <label for="login_email" class="block text-gray-700 mb-2">Email</label>
                <input type="email" name="login_email" id="login_email" required maxlength="128"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
                <p class="text-gray-500 text-sm mt-1">We'll never share your email with anyone else.</p>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="login_password" class="block text-gray-700 mb-2">Password</label>
                <input type="password" name="login_password" id="login_password" required maxlength="64"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"/>
            </div>

            <!-- Login Button -->
            <div class="mb-4">
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded font-semibold transition duration-200">
                    Login
                </button>
            </div>

            <!-- Message -->
            <?php if (!empty($loginResult) && isset($loginResult['message'])): ?>
                <div class="text-red-600 mt-2">
                    <?= htmlspecialchars($loginResult['message']); ?>
                </div>
            <?php endif; ?>

            <!-- Register Link -->
            <p class="text-center text-gray-700 mt-4">
                Don't have an account?
                <a href="signup.php" class="text-red-500 hover:text-red-700 underline">Register Now!</a>
            </p>
        </form>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-100 text-center p-4">
        123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
        ©2026 AnimalMart, Inc. All rights reserved.
    </footer>
</body>
</html>
