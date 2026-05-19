<?php
require_once '../config/database.php';
require_once '../controller/UserController.php';
require_once '../model/UserModel.php';

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Database unavailable");
}

$userModel      = new UserModel($pdo);
$controllerUser = new UserController($userModel, $pdo);

$registerResult = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registerResult = $controllerUser->verifyRegister($_POST, $_FILES);

    if (!empty($registerResult['success'])) {
        header('Location: login.php?registered=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://cdn.tailwindcss.com"></script>
<title>Join AnimalMart!</title>
</head>
<body class="bg-blue-50 min-h-screen flex flex-col">

<!-- NAVBAR -->
<nav class="bg-blue-900 text-white px-6 py-4 flex justify-between items-center">
    <div class="flex space-x-4">
        <a href="Home.php" class="hover:text-blue-300">Home</a>
        <a href="services.php?page=1" class="hover:text-blue-300">Services</a>
        <a href="contact.php" class="hover:text-blue-300">Contact</a>
    </div>
    <div class="text-xl font-bold">Welcome To AnimalMart!</div>
    <div class="flex space-x-4">
        <a href="login.php" class="hover:text-blue-300">Login</a>
        <a href="signup.php" class="text-red-400 underline">Sign Up</a>
    </div>
</nav>

<!-- FORM -->
<main class="flex-grow flex justify-center items-start py-10 px-4">
    <form action="signup.php"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white p-10 rounded-lg shadow-lg w-full max-w-lg">

        <h1 class="text-2xl font-bold text-center mb-6 text-blue-900">Create an Account</h1>

        <?php if (!empty($registerResult)): ?>
            <div class="mb-4 p-3 rounded text-sm font-medium
                        <?= $registerResult['success'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($registerResult['message'], ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <!-- First / Last Name -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 mb-1">First Name</label>
                <input type="text" name="first_name" required maxlength="50"
                       value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Last Name</label>
                <input type="text" name="last_name" required maxlength="100"
                       value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- Username -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Username</label>
            <input type="text" name="username" required maxlength="50"
                   value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Email Address</label>
            <input type="email" name="email" required
                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Password</label>
            <input type="password" name="password" required minlength="8"
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            <p class="text-gray-500 text-sm mt-1">Minimum 8 characters</p>
        </div>

        <!-- City -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">City</label>
            <input type="text" name="city" required maxlength="100"
                   value="<?= htmlspecialchars($_POST['city'] ?? '') ?>"
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">
                Phone Number <span class="text-gray-400 font-normal">(optional)</span>
            </label>
            <input type="tel" name="phone_number" maxlength="20" placeholder="999-999-9999"
                   value="<?= htmlspecialchars($_POST['phone_number'] ?? '') ?>"
                   class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Profile Picture -->
        <div class="mb-6">
            <label class="block text-gray-700 mb-1">
                Profile Picture <span class="text-gray-400 font-normal">(optional)</span>
            </label>
            <input type="file" name="profile_picture" accept="image/*"
                   class="w-full p-2 border rounded bg-white">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded font-semibold transition duration-200">
            Create Account
        </button>

        <p class="text-center text-gray-700 mt-4">
            Already have an account?
            <a href="login.php" class="text-red-500 hover:text-red-700 underline">Log in</a>
        </p>
    </form>
</main>

<!-- FOOTER -->
<footer class="bg-blue-100 text-center p-4">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>

</body>
</html>
