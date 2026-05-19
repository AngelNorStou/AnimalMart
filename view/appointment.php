<?php
declare(strict_types=1);

require_once '../config/session_check.php';
require_once '../config/database.php';
require_once '../model/PetsModel.php';
require_once '../model/UserModel.php';
require_once '../model/ServiceModel.php';
require_once '../model/EmployeesModel.php';
require_once '../model/AppointmentModel.php';
require_once '../controller/ServiceController.php';
require_once '../controller/AppointmentsController.php';

requireLogin();

$pdo = Database::getConnection();

$petModel              = new PetsModel($pdo);
$userModel             = new UserModel($pdo);
$serviceModel          = new ServiceModel($pdo);
$employeesModel        = new EmployeesModel($pdo);
$appointmentModel      = new AppointmentModel($pdo);
$serviceController     = new ServiceController($serviceModel, $pdo);
$appointmentController = new AppointmentController($appointmentModel, $pdo);

$username  = getCurrentUsername();
$user      = $userModel->getUserByUsernameComplete($username);
$pets      = $petModel->displayPetsByUsername($username);
$employees = $employeesModel->getActiveEmployees();

// Pre-selected service from services.php (?service=ID)
$preselectedServiceId = isset($_GET['service']) ? (int)$_GET['service'] : 0;
$preselectedService   = $preselectedServiceId > 0
    ? $serviceModel->displayServiceById($preselectedServiceId)
    : null;

// Fall back to dropdown only if no service was passed
$services = (!$preselectedService) ? $serviceController->displayAllServices() : [];

if (!$user) {
    die("User not found.");
}

$result  = null;
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = trim($_POST['appointment_date'] ?? '');
    $time = trim($_POST['appointment_time'] ?? '');

    $appointmentData = [
        'start_date'  => $date . ' ' . $time . ':00',
        'pet_id'      => $_POST['pet_id'] ?? '',
        'service_id'  => $_POST['service_id'] ?? '',
        'employee_id' => $_POST['employee_id'] ?? '',
        'user_id'     => $user['user_id'],
        'expiry'      => null,
    ];

    $result  = $appointmentController->create($appointmentData);
    $message = $result['message'] ?? ($result['success'] ? 'Appointment booked!' : 'Failed to book appointment.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Book an Appointment | AnimalMart</title>
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
        <a href="<?= isAdmin() ? 'admin_profile.php' : 'user_profile.php' ?>?login=<?= urlencode($username) ?>"
           class="hover:text-blue-300">
            <?= htmlspecialchars($username) ?>
        </a>
        <a href="logout.php" class="text-red-400">Logout</a>
    </div>
</nav>

<!-- MAIN -->
<main class="flex-grow flex justify-center items-start py-10 px-4">
    <div class="bg-white p-10 rounded-lg shadow-lg w-full max-w-2xl">
        <h1 class="text-2xl font-bold text-center mb-6 text-blue-900">Book an Appointment</h1>

        <?php if (!empty($message)): ?>
            <div class="mb-4 p-3 rounded text-sm font-medium <?= ($result && $result['success']) ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($pets)): ?>
            <div class="mb-6 p-4 rounded bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm text-center">
                You have no pets registered yet.
                <a href="addPet.php" class="font-semibold underline hover:text-yellow-900">Add a pet</a>
                before booking an appointment.
            </div>
        <?php endif; ?>

        <form method="POST" action="appointment.php<?= $preselectedServiceId ? '?service=' . $preselectedServiceId : '' ?>">

            <!-- Name row -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-1">First Name</label>
                    <input type="text" value="<?= htmlspecialchars($user['first_name']) ?>" readonly
                           class="w-full p-2 border rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Last Name</label>
                    <input type="text" value="<?= htmlspecialchars($user['last_name']) ?>" readonly
                           class="w-full p-2 border rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>
            </div>

            <!-- Email & Phone -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-1">Email</label>
                    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly
                           class="w-full p-2 border rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Phone Number</label>
                    <input type="tel" value="<?= htmlspecialchars($user['phone_number'] ?? '') ?>" readonly
                           class="w-full p-2 border rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>
            </div>

            <!-- Service (pre-selected or dropdown) -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Service</label>
                <?php if ($preselectedService): ?>
                    <input type="text"
                           value="<?= htmlspecialchars($preselectedService['name']) ?><?= !empty($preselectedService['price']) ? ' — $' . number_format((float)$preselectedService['price'], 2) : '' ?>"
                           readonly
                           class="w-full p-2 border rounded bg-gray-100 text-gray-600 cursor-not-allowed">
                    <input type="hidden" name="service_id" value="<?= $preselectedServiceId ?>">
                <?php else: ?>
                    <select name="service_id" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a service...</option>
                        <?php foreach ($services as $svc): ?>
                            <option value="<?= (int)$svc['service_id'] ?>">
                                <?= htmlspecialchars($svc['name']) ?>
                                <?= !empty($svc['price']) ? ' — $' . number_format((float)$svc['price'], 2) : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
            </div>

            <!-- Pet & Staff -->
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 mb-1">Pet</label>
                    <select name="pet_id" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            <?= empty($pets) ? 'disabled' : '' ?>>
                        <option value="">Choose a pet...</option>
                        <?php foreach ($pets as $pet): ?>
                            <option value="<?= (int)$pet['pet_id'] ?>">
                                <?= htmlspecialchars($pet['pet_name']) ?> (<?= htmlspecialchars($pet['pet_type']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Staff Member</label>
                    <select name="employee_id" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a staff member...</option>
                        <?php foreach ($employees as $emp): ?>
                            <option value="<?= (int)$emp['employee_id'] ?>">
                                <?= htmlspecialchars($emp['first_name'] . ' ' . $emp['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Date & Time (separate inputs) -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 mb-1">Date</label>
                    <input type="date" name="appointment_date"
                           min="<?= date('Y-m-d') ?>" required
                           class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 mb-1">Time</label>
                    <select name="appointment_time" required
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Choose a time...</option>
                        <?php
                        $slots = [];
                        for ($h = 8; $h <= 18; $h++) {
                            $slots[] = sprintf('%02d:00', $h);
                            if ($h < 18) $slots[] = sprintf('%02d:30', $h);
                        }
                        foreach ($slots as $slot):
                            $label = date('g:i A', strtotime($slot));
                        ?>
                            <option value="<?= $slot ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded font-semibold transition duration-200
                           <?= empty($pets) ? 'opacity-50 cursor-not-allowed' : '' ?>"
                    <?= empty($pets) ? 'disabled' : '' ?>>
                Confirm Appointment
            </button>
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
