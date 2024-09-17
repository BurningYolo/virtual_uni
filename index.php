<?php
include_once 'config/db_config.php';
include 'includes/header.php';
include 'includes/sidebar.php';

// Default view
$view = 'dashboard'; // Default to 'dashboard'

if (isset($_GET['page'])) {
    $view = $_GET['page'];
}

// Validate the view name to prevent unauthorized access
$valid_views = ['dashboard', 'library']; // Add other valid views here

if (!in_array($view, $valid_views)) {
    $view = 'dashboard'; // Default to 'dashboard' if invalid view
}

// Include the selected view
$view_file = "views/{$view}.php";

if (file_exists($view_file)) {
    include $view_file;
} else {
    echo "<p>View not found.</p>";
}

include 'includes/footer.php';
?>
