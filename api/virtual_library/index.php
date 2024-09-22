<?php
require_once '../../config/connection.php';

header('Content-Type: application/json');

// Get the search query if available
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Base query to fetch resources
$query = "SELECT * FROM tbl_virtual_library";

// Modify query if search is provided
if ($search) {
    $query .= " WHERE title LIKE :search OR author LIKE :search OR metadata LIKE :search";
}

// Prepare the statement
$stmt = $pdo->prepare($query);

// Bind the search term if applicable
if ($search) {
    $stmt->bindValue(':search', '%' . $search . '%');
}

// Execute the query
$stmt->execute();

// Fetch all resources
$resources = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the resources as JSON
echo json_encode($resources);
?>
