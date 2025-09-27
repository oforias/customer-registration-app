<?php
// Central session and auth helpers

// Ensure session is started exactly once
if (session_status() === PHP_SESSION_NONE) {
    // Secure session cookie params where possible before starting session
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => $cookieParams['path'] ?? '/',
        'domain' => $cookieParams['domain'] ?? '',
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

/**
 * Check whether a user is logged in.
 * Returns true if a session exists indicating authentication, false otherwise.
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true
        && isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id']);
}

/**
 * Check whether the current user has administrative privileges.
 * Assumes role value 1 => admin, other => non-admin.
 */
function isAdmin(): bool
{
    if (!isLoggedIn()) {
        return false;
    }
    return isset($_SESSION['user_role']) && (int)$_SESSION['user_role'] === 1;
}

?>


