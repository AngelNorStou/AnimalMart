<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/EmployeesModel.php';
require_once '../controller/EmployeeController.php';

requireLogin();

if (!isAdmin()) {
    header("Location: login.php");
    exit;
}

$pdo            = Database::getConnection();
$empModel       = new EmployeesModel($pdo);
$controller_emp = new EmployeeController($empModel, $pdo);

$message = null;
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emp_username = trim($_POST['emp_username'] ?? '');
    $emp_date     = $_POST['emp_date'] ?? '';
    $adminOption  = $_POST['adminOption'] ?? '0';

    if (empty($emp_username) || strlen($emp_username) > 32) {
        $message = 'Invalid username.';
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $emp_date)) {
        $message = 'Invalid start date format.';
    } elseif (!in_array($adminOption, ['0', '1'], true)) {
        $message = 'Invalid admin option.';
    } else {
        $result  = $controller_emp->verifyAddEmployee($_POST, getCurrentUsername());
        $message = $result['message'] ?? null;
        $success = $result['success'] ?? false;

        if ($success) {
            header("Location: admin_profile.php?login=" . urlencode(getCurrentUsername()));
            exit;
        }
    }
}

function e(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Employee | AnimalMart</title>
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
               href="admin_profile.php?login=<?= e(getCurrentUsername()) ?>">
                <?= e(getCurrentUsername()) ?>
            </a>
            <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="d-flex align-items-center mb-3">
        <a href="admin_profile.php?login=<?= e(getCurrentUsername()) ?>"
           class="btn btn-outline-secondary btn-sm me-3">← Back</a>
        <h4 class="mb-0">Add Employee</h4>
    </div>

    <?php if ($message): ?>
        <div class="alert <?= $success ? 'alert-success' : 'alert-danger' ?>">
            <?= e($message) ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="max-width: 480px;">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="emp_username" maxlength="32" required>
            <div class="form-text">The user must already have a registered account.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="emp_date" required>
        </div>

        <div class="mb-4">
            <label class="form-label d-block">Admin Privileges</label>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="adminOption" value="0" id="adminNo" checked>
                <label class="form-check-label" for="adminNo">No</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="adminOption" value="1" id="adminYes">
                <label class="form-check-label" for="adminYes">Yes</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Add Employee</button>
        <a href="admin_profile.php?login=<?= e(getCurrentUsername()) ?>"
           class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<footer class="text-center p-4 mt-5" style="background-color: #e9ecef;">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>

</body>
</html>
