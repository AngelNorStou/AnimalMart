<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/EmployeesModel.php';
require_once '../controller/EmployeeController.php';
require_once '../view/EmpView.php';

requireLogin();

if (!isAdmin()) {
    header("Location: login.php");
    exit;
}

$editUser = filter_input(INPUT_GET, 'editUser', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$editUser) {
    header("Location: admin_profile.php");
    exit;
}

$pdo            = Database::getConnection();
$empModel       = new EmployeesModel($pdo);
$empView        = new EmpView($empModel);
$controller_emp = new EmployeeController($empModel, $pdo);

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result  = $controller_emp->verifyEditEmployee($_POST, getCurrentUsername());
    $message = $result['message'] ?? null;

    if (!empty($result['success'])) {
        header("Location: admin_profile.php?login=" . urlencode(getCurrentUsername()));
        exit;
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
    <title>Edit Employee | AnimalMart</title>
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
        <h4 class="mb-0">Edit Employee</h4>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?= e($message) ?></div>
    <?php endif; ?>

    <form method="POST" style="max-width: 480px;">

        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" name="emp_editusername"
                   value="<?= e($editUser) ?>" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" class="form-control" name="emp_date_start"
                   value="<?= e($empView->displayItem($editUser, 'start_date')) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">End Date <span class="text-muted">(leave blank if still active)</span></label>
            <input type="date" class="form-control" name="emp_date_end"
                   value="<?= e($empView->displayItem($editUser, 'end_date')) ?>">
        </div>

        <div class="mb-4">
            <label class="form-label d-block">Admin Privileges</label>
            <?= $empView->displayAdminPower($editUser) ?>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
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
