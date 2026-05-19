<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/ServiceModel.php';
require_once '../controller/ServiceController.php';

requireLogin();

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

$pdo               = Database::getConnection();
$serviceModel      = new ServiceModel($pdo);
$serviceController = new ServiceController($serviceModel, $pdo);

$serviceId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$serviceId) {
    header('Location: admin_profile.php?login=' . urlencode(getCurrentUsername()));
    exit;
}

$service = $serviceController->getServiceById($serviceId);

if (!$service) {
    header('Location: admin_profile.php?login=' . urlencode(getCurrentUsername()));
    exit;
}

$message = null;
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postServiceId = (int)($_POST['service_id'] ?? 0);

    if ($postServiceId !== (int)$service['service_id']) {
        $message = 'Invalid service ID.';
    } elseif (isset($_POST['editService'])) {
        $result  = $serviceController->editService();
        $message = $result['message'] ?? null;
        $success = !empty($result['success']);

        if ($success) {
            header('Location: admin_profile.php?login=' . urlencode(getCurrentUsername()));
            exit;
        }

        $service = $serviceController->getServiceById($serviceId);
    } elseif (isset($_POST['deleteService'])) {
        $result = $serviceController->deleteService();
        if (!empty($result['success'])) {
            header('Location: admin_profile.php?login=' . urlencode(getCurrentUsername()));
            exit;
        }
        $message = $result['message'] ?? 'Delete failed.';
    }
}

function e(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

$username = getCurrentUsername();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Service | AnimalMart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="../CSS/account.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">AnimalMart Admin</span>
        <div>
            <a class="text-white text-decoration-none me-3"
               href="admin_profile.php?login=<?= e($username) ?>">
                <?= e($username) ?>
            </a>
            <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex align-items-center mb-3">
        <a href="admin_profile.php?login=<?= e($username) ?>"
           class="btn btn-outline-secondary btn-sm me-3">← Back</a>
        <h4 class="mb-0">Edit Service: <?= e($service['name']) ?></h4>
    </div>

    <?php if ($message): ?>
        <div class="alert <?= $success ? 'alert-success' : 'alert-danger' ?>">
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="max-width: 480px;">

        <div class="mb-3">
            <label class="form-label">Service Name</label>
            <input type="text" class="form-control" name="name" required
                   value="<?= e($service['name']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="desc" rows="3"><?= e($service['description'] ?? '') ?></textarea>
        </div>

        <div class="row mb-4">
            <div class="col">
                <label class="form-label">Duration (minutes)</label>
                <input type="number" class="form-control" name="length" min="0"
                       value="<?= e((string)($service['duration'] ?? '')) ?>">
            </div>
            <div class="col">
                <label class="form-label">Price ($)</label>
                <input type="number" class="form-control" name="price" step="0.01" min="0" required
                       value="<?= e((string)($service['price'] ?? '')) ?>">
            </div>
        </div>

        <input type="hidden" name="service_id" value="<?= (int)$service['service_id'] ?>">

        <div class="d-flex gap-2">
            <button type="submit" name="editService" class="btn btn-primary">Save Changes</button>
            <button type="submit" name="deleteService" class="btn btn-danger"
                    onclick="return confirm('Delete this service?')">Delete</button>
            <a href="admin_profile.php?login=<?= e($username) ?>"
               class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<footer class="text-center p-4 mt-5" style="background-color: #e9ecef;">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>

</body>
</html>
