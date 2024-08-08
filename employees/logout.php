<?php
// Start the session
session_start();

// Clear all session variables
$_SESSION = array();

// Check if cookies are used for sessions
if (ini_get("session.use_cookies")) {
    // Get session cookie parameters
    $params = session_get_cookie_params();

    // Delete the session cookie by setting its expiration time to one hour ago
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

// Unset a specific session variable if needed (optional)
unset($_SESSION['alogin']);

// Destroy the session
session_destroy();

// Redirect to the index page
header("location:../index.php");
