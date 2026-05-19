<?php
// session_check.php
declare(strict_types=1);

session_start();

// Check if user is logged in based on your session structure
function isLoggedIn(): bool
{
    return !empty($_SESSION['user']['id']) && !empty($_SESSION['user']['username']);
}

// Get current user ID safely
function getCurrentUserId(): ?int
{
    return $_SESSION['user']['id'] ?? null;
}

// Get current username safely
function getCurrentUsername(): ?string
{
    return $_SESSION['user']['username'] ?? null;
}

// Check if user is admin
function isAdmin(): bool
{
    return ($_SESSION['user']['isAdmin'] ?? 0) == 1;
}

// Redirect if not logged in (optional, use where needed)
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}
?>