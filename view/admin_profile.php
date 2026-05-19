<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/UserModel.php';
require_once '../model/EmployeesModel.php';
require_once '../model/MessageModel.php';
require_once '../model/ServiceModel.php';
require_once '../controller/UserController.php';
require_once '../controller/EmployeeController.php';
require_once '../controller/MessageController.php';
require_once '../controller/ServiceController.php';
require_once '../view/UserView.php';
require_once '../view/EmpView.php';

requireLogin();

if (!isAdmin()) {
    header('Location: login.php');
    exit;
}

$username = getCurrentUsername();
$pdo      = Database::getConnection();

$userModel     = new UserModel($pdo);
$userCtrl      = new UserController($userModel, $pdo);
$userView      = new UserView($userModel);

$empModel  = new EmployeesModel($pdo);
$empView   = new EmpView($empModel);
$empCtrl   = new EmployeeController($empModel, $pdo);

$msgModel  = new MessageModel($pdo);
$msgCtrl   = new MessageController($msgModel, $pdo);

$serviceModel = new ServiceModel($pdo);
$serviceCtrl  = new ServiceController($serviceModel, $pdo);

$updateError   = null;
$passwordError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['update'])) {
        $result      = $userCtrl->verifyUpdate($_POST);
        $updateError = $result['success'] ? null : ($result['message'] ?? 'Update failed');
    }

    if (isset($_POST['changePassword'])) {
        $result        = $userCtrl->verifyPasswordChange($_POST);
        $passwordError = $result['success'] ? null : ($result['message'] ?? 'Change failed');
    }

    if (isset($_POST['deleteEmployee'])) {
        $empId = (int)($_POST['employee_id'] ?? 0);
        $emp   = $empModel->getEmployeeById($empId);
        if ($emp) {
            $empModel->deleteEmployee((int)$emp['user_id']);
        }
    }

    if (isset($_POST['deleteUser'])) {
        $userCtrl->verifyDelete($_POST);
    }

    if (isset($_POST['deleteMessage'])) {
        $msgCtrl->delete((int)($_POST['message_id'] ?? 0));
    }

    if (isset($_POST['deleteService'])) {
        $serviceCtrl->deleteService();
    }
}

$messages = $msgCtrl->display();
$users    = $userModel->getAllUsers();
$services = $serviceModel->displayService();

function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="../CSS/account.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">AnimalMart Admin</span>
        <div>
            <span class="text-white me-3"><?= e($username) ?></span>
            <a class="btn btn-danger btn-sm" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

<ul class="nav nav-pills mb-3">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#account">Account</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#employees">Employees</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#services">Services</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#messages">Messages</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#users">Users</button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#password">Password</button></li>
</ul>

<div class="tab-content">

<!-- ACCOUNT -->
<div class="tab-pane fade show active" id="account">
    <img src="<?= $userView->displayPictureSource($username) ?>" width="150" height="150" class="img-thumbnail mb-3" alt="Profile">

    <form method="POST">
        <div class="mb-2">
            <label class="form-label">First Name</label>
            <input class="form-control" name="ufirstname" value="<?= $userView->displayItem($username,'first_name') ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Last Name</label>
            <input class="form-control" name="ulastname" value="<?= $userView->displayItem($username,'last_name') ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Email</label>
            <input class="form-control" name="uemail" type="email" value="<?= $userView->displayItem($username,'email') ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label">City</label>
            <input class="form-control" name="ucity" value="<?= $userView->displayItem($username,'city') ?>" required>
        </div>
        <div class="mb-2">
            <label class="form-label">Phone</label>
            <input class="form-control" name="uphone" value="<?= $userView->displayItem($username,'phone_number') ?>">
        </div>
        <div class="mb-2">
            <label class="form-label">Username</label>
            <input class="form-control" name="uusername" value="<?= $userView->displayItem($username,'username') ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Current Password (required to save)</label>
            <input class="form-control" name="upassword" type="password" required>
        </div>

        <button class="btn btn-primary" name="update">Update</button>
        <?php if ($updateError): ?>
            <div class="text-danger mt-2"><?= e($updateError) ?></div>
        <?php endif; ?>
    </form>
</div>

<!-- EMPLOYEES -->
<div class="tab-pane fade" id="employees">
    <a class="btn btn-success mb-2" href="addEmp.php">Add Employee</a>
    <table class="table">
        <thead><tr><th>First Name</th><th>Last Name</th><th>Start Date</th><th>End Date</th><th>Actions</th></tr></thead>
        <tbody><?= $empView->getAllEmployees($username) ?></tbody>
    </table>
</div>

<!-- SERVICES -->
<div class="tab-pane fade" id="services">
    <a class="btn btn-success mb-3" href="addService.php">Add Service</a>
    <table class="table table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Duration (min)</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($services as $svc): ?>
            <tr>
                <td><?= e($svc['name']) ?></td>
                <td><?= e($svc['type']) ?></td>
                <td><?= e((string)($svc['duration'] ?? '—')) ?></td>
                <td>$<?= e(number_format((float)($svc['price'] ?? 0), 2)) ?></td>
                <td class="d-flex gap-2">
                    <a href="editService.php?id=<?= (int)$svc['service_id'] ?>"
                       class="btn btn-primary btn-sm">Edit</a>
                    <form method="POST" onsubmit="return confirm('Delete this service?')">
                        <input type="hidden" name="service_id" value="<?= (int)$svc['service_id'] ?>">
                        <button class="btn btn-danger btn-sm" name="deleteService">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($services)): ?>
            <tr><td colspan="5" class="text-center text-muted">No services found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- MESSAGES -->
<div class="tab-pane fade" id="messages">
<table class="table">
<thead><tr><th>From</th><th>Email</th><th>Subject</th><th>Message</th><th></th></tr></thead>
<tbody>
<?php foreach ($messages as $msg): ?>
<tr>
    <td><?= e($msg['name'] ?? $msg['username'] ?? '') ?></td>
    <td><?= e($msg['email'] ?? '') ?></td>
    <td><?= e($msg['subject'] ?? '') ?></td>
    <td><?= e($msg['message'] ?? '') ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="message_id" value="<?= (int)$msg['message_id'] ?>">
            <button class="btn btn-danger btn-sm" name="deleteMessage"
                    onclick="return confirm('Delete message?')">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<!-- USERS -->
<div class="tab-pane fade" id="users">
<table class="table">
<thead><tr><th>Username</th><th>Email</th><th></th></tr></thead>
<tbody>
<?php foreach ($users as $u): ?>
<tr>
    <td><?= e($u['username']) ?></td>
    <td><?= e($u['email']) ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="user_id" value="<?= (int)$u['user_id'] ?>">
            <button class="btn btn-danger btn-sm" name="deleteUser"
                    onclick="return confirm('Delete user?')">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>

<!-- PASSWORD -->
<div class="tab-pane fade" id="password">
<form method="POST">
    <div class="mb-2">
        <label class="form-label">Username</label>
        <input class="form-control" name="current_user" value="<?= e($username) ?>" readonly required>
    </div>
    <div class="mb-2">
        <label class="form-label">Current Password</label>
        <input class="form-control" name="current_password" type="password" required>
    </div>
    <div class="mb-3">
        <label class="form-label">New Password</label>
        <input class="form-control" name="new_password" type="password" required>
    </div>

    <button class="btn btn-primary" name="changePassword">Change Password</button>
    <?php if ($passwordError): ?>
        <div class="text-danger mt-2"><?= e($passwordError) ?></div>
    <?php endif; ?>
</form>
</div>

</div>
</div>

</body>
</html>
