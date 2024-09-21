<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Prepare a response message
    $response = [
        'success' => true,
        'message' => 'Successfully signed out.'
    ];
} else {
    // If the user is not logged in, provide an appropriate message
    $response = [
        'success' => false,
        'message' => 'You are not logged in.'
    ];
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Redirect to login-signup page
header('Location: ../index.php');
exit();
