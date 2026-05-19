<?php
require_once '../config/database.php';
require_once '../model/ServiceModel.php';
require_once '../controller/ServiceController.php';

require_once '../config/session_check.php';


try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Database unavailable");
}

$service = new ServiceModel($pdo);

$controllerService = new ServiceController($service ,$pdo);


$page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0
    ? (int) $_GET['page']
    : 1;

$resultsPerPage = 4;
$offset = ($page - 1) * $resultsPerPage;


$isSearching = isset($_GET['searchInput']) && trim($_GET['searchInput']) !== '';
$services    = $isSearching
    ? $controllerService->search()
    : $controllerService->getServices($resultsPerPage, $offset);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Services | AnimalMart</title>
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

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-blue-900">Our Services</h1>

        <?php if (!empty($_SESSION['user']['isAdmin'])): ?>
            <a href="add_service.php"
               class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Add Service
            </a>
        <?php endif; ?>
    </div>

    <!-- SEARCH -->
    <form method="GET" class="flex gap-2 mb-8">
        <input type="text"
               name="searchInput"
               placeholder="Search services..."
               value="<?= htmlspecialchars($_GET['searchInput'] ?? '') ?>"
               class="flex-1 p-2 border rounded focus:ring-2 focus:ring-blue-500">

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Search
        </button>

        <a href="services.php?page=1"
           class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
            Clear
        </a>
    </form>

    <!-- SERVICES GRID -->
    <div class="grid md:grid-cols-2 gap-6">

        <?php foreach ($services as $service): ?>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold text-blue-900">
                    <?= htmlspecialchars($service['name']) ?>
                </h2>

                <p class="text-gray-600 mt-2">
                    Type: <?= htmlspecialchars($service['type']) ?><br>
                    Price: $<?= htmlspecialchars($service['price']) ?>
                    <?php if (!empty($service['duration'])): ?>
                        <br>Length: <?= htmlspecialchars($service['duration']) ?> minutes
                    <?php endif; ?>
                </p>

                <?php if (!empty($service['description'])): ?>
                    <p class="mt-3 text-gray-700">
                        <?= htmlspecialchars($service['description']) ?>
                    </p>
                <?php endif; ?>

                <div class="mt-4 flex gap-2">
                    <a href="appointment.php?service=<?= (int)$service['service_id'] ?>"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Book Appointment
                    </a>

                    <?php if (!empty($_SESSION['user']['isAdmin'])): ?>
                        <a href="edit_service.php?service=<?= (int)$service['service_id'] ?>"
                           class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Edit
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    </div>

    <!-- PAGINATION (hidden during search) -->
    <?php if (!$isSearching): ?>
    <div class="mt-10">
        <?= $controllerService->displayPagination($resultsPerPage); ?>
    </div>
    <?php endif; ?>

</main>

<!-- FOOTER -->
<footer class="bg-blue-100 text-center p-4">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>

</body>
</html>
