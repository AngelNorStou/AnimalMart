<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/UserModel.php';
require_once '../controller/UserController.php';

requireLogin();

$pdo            = Database::getConnection();
$userModel      = new UserModel($pdo);
$controllerUser = new UserController($userModel, $pdo);

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upicture'])) {

    $result  = $controllerUser->verifyPictureChange($_FILES, getCurrentUsername());
    $message = $result['message'] ?? '';

    if ($result['success']) {
        header('Location: ' . (isAdmin() ? 'admin_profile.php' : 'user_profile.php') . '?login=' . urlencode(getCurrentUsername()));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../CSS/account.css" rel="stylesheet">
    <title>Change Picture</title>
</head>
<body>
<nav style="background: darkblue;" class="navbar navbar-expand-md navbar-dark">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="nav">
            <li class="nav-item"><a class="nav-link" style="color: lightblue;" href="Home.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" style="color: lightblue;" href="services.php?page=1">Services Offered</a></li>
            <li class="nav-item"><a class="nav-link" style="color: lightblue;" href="contact.php">Contact</a></li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <span style="font-size: 30px;" class="navbar-brand mx-auto">Welcome To AnimalMart!</span>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link active" style="color: white;"
                   href="<?= isAdmin() ? 'admin_profile.php' : 'user_profile.php' ?>?login=<?= htmlspecialchars(getCurrentUsername()) ?>">
                    <?= htmlspecialchars(getCurrentUsername()) ?>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" style="color: red;" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <form id="userPicture" action="" method="POST" enctype="multipart/form-data" class="p-4 bg-light rounded">
        <h3>Select a new image file for your profile picture.</h3>
        <div class="mb-3">
            <input class="form-control form-control-lg" name="upicture" id="upicture" type="file" accept="image/*" required>
        </div>
        <button type="submit" class="btn btn-primary">Confirm Changes</button>
    </form>
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= str_contains($message, 'success') ? 'success' : 'danger' ?> mt-3">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
</div>

<footer class="text-center mt-5 p-3" style="background-color: lightblue;">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>
</body>
</html>
