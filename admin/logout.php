<?php
session_start(); // Start the session to access session variables

$_SESSION = array(); // Clear all session variables

// Check if session cookies are used
if (ini_get("session.use_cookies")) {
    // Get current cookie parameters
    $params = session_get_cookie_params();

    // Expire the session cookie by setting its expiration time in the past
    setcookie(
        session_name(),
        '',
        time() - 60 * 60,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Unset specific session variable (if it exists)
unset($_SESSION['alogin']);

// Destroy the session
session_destroy();

// Redirect to the homepage
header("location:../index.php");
