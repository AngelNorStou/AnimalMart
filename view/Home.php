<?php
require_once '../config/session_check.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>AnimalMart | Home</title>
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

<!-- HERO SECTION -->
<section class="bg-blue-100 py-12">
    <div class="container mx-auto grid md:grid-cols-3 gap-6 items-center px-6">
        <!-- Training -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-3xl font-bold text-blue-900 mb-2">TRAINING!</h2>
            <p class="text-red-600 font-semibold mb-2">Explore our new group training sessions offered!</p>
            <p class="text-blue-900">Sign up or Login now &amp; Book your appointment!</p>
        </div>

        <!-- Image -->
        <div class="text-center">
            <img src="../Images/pet_store1.jpg" alt="Pets" class="mx-auto rounded-lg shadow-md w-full max-w-xl">
            <p class="mt-4 text-red-600 text-xl font-medium">Take care of your pet's needs, all in one place.</p>
        </div>

        <!-- Grooming -->
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <h2 class="text-3xl font-bold text-blue-900 mb-2">GROOMING!</h2>
            <p class="text-red-600 font-semibold mb-2">Explore all our grooming services for every pet!</p>
            <p class="text-blue-900">Sign up or Login now &amp; Book your appointment!</p>
        </div>
    </div>
</section>

<!-- REVIEWS SECTION -->
<section class="bg-blue-50 py-12">
    <h2 class="text-3xl text-center font-bold text-blue-900 mb-8">Reviews from our customers!</h2>

    <div class="container mx-auto grid md:grid-cols-3 gap-6 px-6">
        <!-- Review 1 -->
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center gap-4">
                <img src="../Images/dog.jpg" alt="Dog" class="w-24 h-24 rounded-lg object-cover">
                <div>
                    <h3 class="font-bold text-blue-900">Mary Owen</h3>
                    <p class="text-gray-700">Great local shop! The staff is always happy to help and are all knowledgeable when it comes to pet care. My dog loves going to AnimalMart!</p>
                    <p class="text-gray-500 text-sm mt-1">Service: Grooming</p>
                </div>
            </div>
        </div>

        <!-- Review 2 -->
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center gap-4">
                <img src="../Images/bunny.jpg" alt="Bunny" class="w-24 h-24 rounded-lg object-cover">
                <div>
                    <h3 class="font-bold text-blue-900">Maxim Party</h3>
                    <p class="text-gray-700">Fantastic team, fantastic service. My bunny had digestive issues and the team gave excellent advice. Purchase all your pets' needs here!</p>
                    <p class="text-gray-500 text-sm mt-1">Service: Health</p>
                </div>
            </div>
        </div>

        <!-- Review 3 -->
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center gap-4">
                <img src="https://lh5.googleusercontent.com/p/AF1QipOSd-S225TZD4cM3CYqb4GC0k67udzJ_vBU5-RT=w100-h100-p-n-k-no" alt="Pet" class="w-24 h-24 rounded-lg object-cover">
                <div>
                    <h3 class="font-bold text-blue-900">Becca Maurice</h3>
                    <p class="text-gray-700">Banjo has been doing amazing! The advice from the staff is always helpful and customer service is top notch.</p>
                    <p class="text-gray-500 text-sm mt-1">Service: Health</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-blue-100 text-center p-4 mt-auto">
    123 Boul. Ecommerce, Toronto, ON M4A 6L1<br>
    ©2026 AnimalMart, Inc. All rights reserved.
</footer>

</body>
</html>
