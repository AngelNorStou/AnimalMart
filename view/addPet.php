<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/PetsModel.php';
require_once '../controller/PetController.php';

requireLogin();

$pdo = Database::getConnection();

$petModel      = new PetsModel($pdo);
$petController = new PetController($petModel, $pdo);

$addError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $addError = $petController->verifyAddPet($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Add Pet | AnimalMart</title>
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
        <a href="user_profile.php" class="hover:text-blue-300">
            <?= htmlspecialchars(getCurrentUsername()) ?>
        </a>
        <a href="logout.php" class="text-red-400">Logout</a>
    </div>
</nav>

<!-- MAIN -->
<main class="flex-grow flex justify-center items-start py-10 px-4">
    <form method="POST"
          action="addPet.php"
          class="bg-white p-10 rounded-lg shadow-lg w-full max-w-lg">

        <h1 class="text-2xl font-bold text-center mb-6 text-blue-900">Add Your Pet</h1>

        <?php if (!empty($addError)): ?>
            <div class="mb-4 p-3 rounded text-sm font-medium bg-red-100 text-red-700">
                <?= htmlspecialchars($addError) ?>
            </div>
        <?php endif; ?>

        <!-- Name & Type -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 mb-1">Pet Name</label>
                <input type="text" name="pet_name" required maxlength="30"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Pet Type</label>
                <input type="text" name="type" required maxlength="30"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <!-- Breed & Gender -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 mb-1">Breed</label>
                <input type="text" name="breed" required maxlength="64"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Gender</label>
                <select name="gender" required
                        class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
            </div>
        </div>

        <!-- Size, Weight, Age -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 mb-1">Size (cm)</label>
                <input type="number" name="size" required step="0.01" min="0"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Weight (kg)</label>
                <input type="number" name="weight" required step="0.01" min="0"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-gray-700 mb-1">Age</label>
                <input type="number" name="age" required min="0"
                       class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <input type="hidden" name="user" value="<?= htmlspecialchars(getCurrentUsername()) ?>">

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded font-semibold transition duration-200">
            Add Pet
        </button>
    </form>
</main>

<!-- FOOTER -->
<footer class="bg-blue-100 text-center p-4">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>

</body>
</html>
