<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Unset all session variables
 */
$_SESSION = [];

/**
 * Delete session cookie (prevents session fixation reuse)
 */
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

/**
 * Destroy session
 */
session_destroy();

/**
 * Redirect safely
 */
header('Location: Home.php');
exit;
