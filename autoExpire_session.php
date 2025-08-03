<?php

$timeout = 10; // 1 hour = 3600 seconds

// Check if user is logged in
if (isset($_SESSION['user'])) {
    
    // Check for session timeout
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
        // Session expired
        session_unset();            // Unset all session variables
        session_destroy();          // Destroy session
        header("Location: index.php");
        exit();
    }

    // Update last activity time
    $_SESSION['last_activity'] = time();
} else {
    // If user is not logged in, redirect to login
    header("Location: index.php");
    exit();
}
?>
