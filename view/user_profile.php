<?php
declare(strict_types=1);
require_once '../config/session_check.php';



if (empty($_SESSION['user']['username'])) {
    header('Location: login.php');
    exit;
}

//Security note for anyone reading: Only rely on session data for the currently logged-in user. 
// Never trust GET parameters like ?login=GM for security-critical actions, because a malicious user can change them.
$username = $_SESSION['user']['username'];

$userId = (int)$_SESSION['user']['id'];


require_once '../config/database.php';
require_once '../model/UserModel.php';
require_once '../controller/UserController.php';
require_once '../view/UserView.php';

require_once '../model/PetsModel.php';
require_once '../view/PetView.php';

require_once '../model/ServiceModel.php';
require_once '../model/AppointmentModel.php';
require_once '../controller/AppointmentsController.php';



$pdo = Database::getConnection();
$userModel      = new UserModel($pdo);
$userController = new UserController($userModel,$pdo);
$userView       = new UserView($userModel);

$petModel = new PetsModel($pdo);
$petView  = new PetView($petModel);

$serviceModel = new ServiceModel($pdo);

$appointmentModel = new AppointmentModel($pdo);
$appointmentController = new AppointmentController($appointmentModel, $pdo);
$appointments = $appointmentController->getAppointments($username);


$updateError   = null;
$passwordError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $updateError = $userController->verifyUpdate($_POST);

    // After successful update, reload the user from DB
    if (!empty($updateError) && $updateError['success'] === true) {
        // Optionally update session username/email if changed
        $_SESSION['user']['email'] = $_POST['uemail'] ?? $_SESSION['user']['email'];
    }
}

// When rendering the form:
$firstname = $_POST['ufirstname'] ?? $userView->displayField($username,'first_name');
$lastname  = $_POST['ulastname'] ?? $userView->displayField($username,'last_name');
$email     = $_POST['uemail'] ?? $userView->displayField($username,'email');
// ... same for other fields


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['changePassword'])) {
        $passwordError = $userController->verifyPasswordChange($_POST);
    }

    if (isset($_POST['deleteUser'])) {
        $userController->verifyDelete($_POST);

        session_unset();
        session_destroy();

        header('Location: Home.php');
        exit;
    }
}


function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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


<!-- Main Container -->
<div class="container mx-auto mt-6 px-4">

    <!-- Tabs -->
    <div class="flex flex-wrap border-b border-gray-300 mb-6">
        <button class="tab-button px-4 py-2 text-gray-700 border-b-2 border-blue-500 font-semibold" data-tab="account">Account</button>
        <button class="tab-button px-4 py-2 text-gray-700 hover:text-blue-500" data-tab="pets">Pets</button>
        <button class="tab-button px-4 py-2 text-gray-700 hover:text-blue-500" data-tab="appointments">Appointments</button>
        <button class="tab-button px-4 py-2 text-gray-700 hover:text-blue-500" data-tab="password">Password</button>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
      <!-- ACCOUNT -->
        <div class="tab-panel active" id="account">
            <!-- ONLY THE EXISTING ACCOUNT CONTENT GOES HERE -->
            <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
                <img src="<?= $userView->displayPictureSource($username) ?>" alt="Profile Picture" class="w-32 h-32 rounded-full object-cover">
                
                <form method="POST" class="flex-1 space-y-2">
                    <div>
                        <label class="block text-gray-700">Username</label>
                        <input type="text" name="uusername" value="<?= $userView->displayField($username,'username') ?>" class="form-control mb-2" required>
                    </div>                   
                    <div>
                        <label class="block text-gray-700">First Name</label>
                        <input type="text" name="ufirstname" class="w-full p-2 border rounded" value="<?= $userView->displayField($username,'first_name') ?>" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Last Name</label>
                        <input type="text" name="ulastname" class="w-full p-2 border rounded" value="<?= $userView->displayField($username,'last_name') ?>" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Email</label>
                        <input type="email" name="uemail" class="w-full p-2 border rounded" value="<?= $userView->displayField($username,'email') ?>" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">City</label>
                        <input type="text" name="ucity" class="w-full p-2 border rounded" value="<?= $userView->displayField($username,'city') ?>" required>
                    </div>
                    <div>
                        <label class="block text-gray-700">Phone</label>
                        <input type="tel" name="uphone" class="w-full p-2 border rounded" value="<?= $userView->displayField($username,'phone_number') ?>">
                    </div>
                    <div>
                        <label class="block text-gray-700">Password</label>
                        <input type="password" name="upassword" class="w-full p-2 border rounded" required>
                    </div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" name="update">Update Profile</button>
                    <?php if (is_array($updateError)): ?>
                        <div class="<?= $updateError['success'] ? 'text-green-500' : 'text-red-500' ?>">
                            <?= e($updateError['message'] ?? '') ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>               
        </div>
        <!-- PETS TAB -->
        <div class="tab-panel" id="pets">
            <div class="p-4">
                <a href="addPet.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4 inline-block">Add Pet</a>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php 
                    // Debug: Check if pets are being loaded
                    $userPets = $petView->displayPets($username);
                    if (empty($userPets)) {
                        echo '<div class="col-span-3 text-center p-8 bg-white rounded shadow">';
                        echo '<p class="text-gray-600">No pets found. Add your first pet!</p>';
                        echo '</div>';
                    } else {
                        echo $userPets;
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- APPOINTMENTS TAB -->
        <div class="tab-panel" id="appointments">
            <div class="p-4">
                <?php 
                // Debug: Check appointments
                if (empty($appointments)) {
                    echo '<div class="bg-white p-8 rounded shadow text-center">';
                    echo '<p class="text-gray-600">No appointments found.</p>';
                    echo '<a href="services.php" class="text-blue-500 hover:underline mt-2 inline-block">Book an appointment</a>';
                    echo '</div>';
                } else {
                ?>
                <table class="min-w-full bg-white shadow rounded overflow-hidden">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 text-left">Date</th>
                            <th class="py-2 px-4 text-left">Pet</th>
                            <th class="py-2 px-4 text-left">Service</th>
                            <th class="py-2 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ((array)$appointments as $appt): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4"><?= htmlspecialchars($appt['start_date'] ?? 'N/A') ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($appt['pet_name'] ?? 'Unknown') ?></td>
                                <td class="py-2 px-4"><?= htmlspecialchars($appt['service_name'] ?? 'Unknown') ?></td>
                                <td class="py-2 px-4 flex gap-3">
                                    <a href="editAppointment.php?appointment_id=<?= (int)($appt['appointment_id'] ?? 0) ?>"
                                       class="text-blue-500 hover:underline">Edit</a>
                                    <form method="POST" action="deleteAppointment.php" onsubmit="return confirm('Cancel this appointment?')">
                                        <input type="hidden" name="appointment_id" value="<?= (int)($appt['appointment_id'] ?? 0) ?>">
                                        <button class="text-red-500 hover:underline">Cancel</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>

        <!-- PASSWORD TAB -->
        <div class="tab-panel" id="password">
            <div class="p-4 max-w-md">
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="current_user" value="<?= $username ?>">
                    
                    <div>
                        <label class="block text-gray-700 mb-2">Current Password</label>
                        <input type="password" name="current_password" class="w-full p-2 border rounded" required>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 mb-2">New Password</label>
                        <input type="password" name="new_password" class="w-full p-2 border rounded" required>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 mb-2">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="w-full p-2 border rounded" required>
                    </div>
                    
                    <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" name="changePassword">Change Password</button>
                    
                    <?php if (is_array($passwordError)): ?>
                        <div class="<?= $passwordError['success'] ? 'text-green-500' : 'text-red-500' ?> mt-2">
                            <?= e($passwordError['message'] ?? '') ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {
    console.log('Document ready - tabs initialized');
    
    // Hide all tabs except the active one
    $('.tab-panel').not('.active').hide();
    
    // Set initial active tab button
    $('.tab-button[data-tab="account"]').addClass('border-blue-500 font-semibold');
    
    // Tab click handler
    $('.tab-button').click(function(e) {
        e.preventDefault();
        
        var tabId = $(this).data('tab');
        console.log('Switching to tab:', tabId);
        
        // Remove active classes from all tabs
        $('.tab-button').removeClass('border-blue-500 font-semibold text-blue-600')
                       .addClass('text-gray-700');
        
        // Add active class to clicked tab button
        $(this).removeClass('text-gray-700')
               .addClass('border-blue-500 font-semibold text-blue-600');
        
        // Hide all tab content
        $('.tab-panel').hide().removeClass('active');
        
        // Show selected tab content
        var $selectedTab = $('#' + tabId);
        console.log('Selected tab element:', $selectedTab.length ? 'Found' : 'Not found');
        console.log('Selected tab HTML:', $selectedTab.html() ? 'Has content' : 'Empty');
        
        $selectedTab.show().addClass('active');
        
        // Update URL hash for bookmarking
        window.location.hash = tabId;
    });
    
    // Check URL hash on load
    if (window.location.hash) {
        var hash = window.location.hash.substring(1);
        console.log('Found hash in URL:', hash);
        $('[data-tab="' + hash + '"]').click();
    }
    
    // Debug: Log all tab elements
    console.log('Tab buttons found:', $('.tab-button').length);
    console.log('Tab panels found:', $('.tab-panel').length);
    $('.tab-panel').each(function(index) {
        console.log('Tab panel #' + index + ' ID:', this.id, 'Visible:', $(this).is(':visible'));
    });
});
</script>

</body>
</html>