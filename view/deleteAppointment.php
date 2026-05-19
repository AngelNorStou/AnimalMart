<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/AppointmentModel.php';
require_once '../controller/AppointmentsController.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['appointment_id'])) {
    header("Location: user_profile.php?login=" . urlencode(getCurrentUsername()));
    exit;
}

$appointmentId = filter_input(INPUT_POST, 'appointment_id', FILTER_VALIDATE_INT);
if (!$appointmentId) {
    header("Location: user_profile.php?login=" . urlencode(getCurrentUsername()));
    exit;
}

$pdo = Database::getConnection();
$appointmentModel      = new AppointmentModel($pdo);
$appointmentController = new AppointmentController($appointmentModel, $pdo);

$appointment = $appointmentController->getById($appointmentId);

if (!$appointment || $appointment['username'] !== getCurrentUsername()) {
    header("Location: user_profile.php?login=" . urlencode(getCurrentUsername()));
    exit;
}

$result = $appointmentController->delete(['appointment_id' => $appointmentId]);

if ($result['success']) {
    header("Location: user_profile.php?login=" . urlencode(getCurrentUsername()) . "&msg=deleted");
} else {
    header("Location: user_profile.php?login=" . urlencode(getCurrentUsername()) . "&error=delete_failed");
}
exit;
