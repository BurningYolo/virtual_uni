<?php
session_start();

// Include necessary configuration files
include_once('config/db_config.php');
include('config/directroy.php'); 
define('APP_RUNNING', true);

// Check if the user is logged in
if (isset($_SESSION['email']) && isset($_SESSION['role']) && isset($_SESSION['user_id'] ) ) {
    include(BASE_DIR . 'includes/header.php');
    include(BASE_DIR . 'includes/sidebar.php');

    // Default view
    $view = 'dashboard';

    // Check if a specific view is requested
    if (isset($_GET['page'])) {
        $view = $_GET['page'];
    }

    // Validate the view name to prevent unauthorized access
    $valid_views = ['dashboard', 'library', 'profile', 'feedback', 'posts', 'events', 'information_kiosks' , 'discussion_boards'];

    if (!in_array($view, $valid_views)) {
        $view = 'dashboard';
    }

    // Include the appropriate handler for the view
    $handler_file = BASE_DIR . "handlers/{$view}_handler.php";
    if (file_exists($handler_file)) {
        include($handler_file);
    } else {
        echo "<p>Handler for {$view} not found.</p>";
    }

    // Include the selected view
    $view_file = BASE_DIR . "views/{$view}.php";
    if (file_exists($view_file)) {
        include($view_file);
    } else {
        echo "<p>View not found.</p>";
    }

    include(BASE_DIR . 'includes/footer.php');

} else {
    $view = 'login-signup' ; 
    
    $handler_file = BASE_DIR . "handlers/{$view}_handler.php";
    if (file_exists($handler_file)) {
        include($handler_file);
    } else {
        echo "<p>Handler for {$view} not found.</p>";
    }
    // User is not logged in, load the login/signup view
    $view_file = BASE_DIR . 'views/login-signup.php';

    if (file_exists($view_file)) {
        include($view_file);
    } else {
        echo "<p>Login/Signup view not found.</p>";
    }
   
}
