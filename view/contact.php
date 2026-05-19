<?php
require_once '../config/database.php';
require_once '../controller/MessageController.php';
require_once '../model/MessageModel.php';

require_once '../config/session_check.php';

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Database unavailable");
}
$message = new MessageModel($pdo);
$messageObj = new MessageController($message,$pdo);
$response = [];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = [
    'name'    => trim(($_POST['firstname'] ?? '') . ' ' . ($_POST['lastname'] ?? '')),
    'email'   => trim($_POST['email'] ?? ''),
    'phone'   => trim($_POST['phone'] ?? ''),
    'subject' => trim($_POST['subject'] ?? 'Message from contact form'),
    'message' => trim($_POST['message'] ?? '')
];

    $userId = $_SESSION['user_id'] ?? null;
    $response = $messageObj->insertMessage($postData, $userId);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us | AnimalMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex flex-col">

<!-- NAVBAR -->
<nav class="bg-blue-900 text-white px-6 py-4 flex flex-col md:flex-row justify-between items-center md:items-center space-y-2 md:space-y-0">
    <div class="flex space-x-4">
        <a href="Home.php" class="underline">Home</a>
        <a href="services.php?page=1" class="hover:text-blue-300">Services</a>
        <a href="contact.php" class="hover:text-blue-300">Contact</a>
    </div>

    <div class="text-xl font-bold">Welcome To AnimalMart!</div>

    <div class="flex space-x-4">
        <?php if (!isLoggedIn()): ?>
            <a href="login.php" class="text-red-400">Login</a>
            <a href="signup.php" class="text-red-400">Sign Up</a>
        <?php else: ?>
                <a href="user_profile.php" class="text-white">
                    <?= htmlspecialchars(getCurrentUsername()) ?>
                </a>
            <a href="logout.php" class="text-red-400">Logout</a>
        <?php endif; ?>
    </div>
</nav>

<!-- MAIN -->
<main class="flex-grow container mx-auto px-6 py-10">
    <div class="max-w-2xl mx-auto text-center">
        <h1 class="text-3xl font-bold text-blue-900 mb-6">Contact Us</h1>

        <?php if (!empty($response)): ?>
            <div class="mb-6 p-4 rounded <?= $response['success'] ? 'bg-green-200 text-green-900' : 'bg-red-200 text-red-900' ?>">
                <?= htmlspecialchars($response['message']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="bg-white p-8 rounded-lg shadow-lg space-y-4">

            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium text-blue-900">First Name</label>
                    <input type="text" name="firstname" required
                           value="<?= htmlspecialchars($_POST['firstname'] ?? '') ?>"
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-medium text-blue-900">Last Name</label>
                    <input type="text" name="lastname" required
                           value="<?= htmlspecialchars($_POST['lastname'] ?? '') ?>"
                           class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block font-medium text-blue-900">Email</label>
                <input type="email" name="email" required
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="example@web.ca">
            </div>

            <div>
                <label class="block font-medium text-blue-900">Phone Number</label>
                <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="999-999-9999">
            </div>

            <div>
                <label class="block font-medium text-blue-900">Subject</label>
                <input type="text" name="subject"
                       value="<?= htmlspecialchars($_POST['subject'] ?? 'Message from contact form') ?>"
                       class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block font-medium text-blue-900">Message</label>
                <textarea name="message" rows="5" required
                          class="w-full px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Your message..."><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
            </div>

            <div class="text-center">
                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Send Message
                </button>
            </div>

        </form>
    </div>
</main>

<!-- FOOTER -->
<footer class="bg-blue-100 text-center p-4">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>

</body>
</html>
