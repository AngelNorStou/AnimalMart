<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/PetsModel.php';

requireLogin();

$pdo = Database::getConnection();

$petId = isset($_GET['petDelete']) ? (int)$_GET['petDelete'] : 0;

if ($petId <= 0) {
    header('Location: user_profile.php?login=' . urlencode(getCurrentUsername()));
    exit;
}

$petModel = new PetsModel($pdo);

$owner = $petModel->getUsername($petId);
if ($owner !== getCurrentUsername()) {
    header('Location: user_profile.php?login=' . urlencode(getCurrentUsername()));
    exit;
}

$petModel->deletePet($petId);

header('Location: user_profile.php?login=' . urlencode(getCurrentUsername()));
exit;
