<?php
// Include database configuration
$config = require 'db_config.php'; // Adjust the path as necessary

// Extract configuration variables
$host = $config['host'];
$db   = $config['db'];
$user = $config['user'];
$pass = $config['pass'];
$charset = $config['charset'];
$authKey = $config['auth_key']; // Get the stored auth_key from db_config

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Check if auth_key is provided in the request (GET or POST)
$userAuthKey = isset($_REQUEST['auth_key']) ? $_REQUEST['auth_key'] : null;

if (!$userAuthKey) {
    // If no auth_key is provided
    exit('Auth key is not provided.');
}

if ($userAuthKey !== $authKey) {
    // If auth_key does not match
    exit('Invalid auth key.');
}

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Continue with your script logic here...
} catch (\PDOException $e) {
    // Handle connection error
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
