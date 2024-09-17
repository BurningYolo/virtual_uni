<?php
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'signup') {
        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'student';

        $url = './api/users/create.php?auth_key=gWm74b2i1Eutf8mb4';
        $data = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'auth_key' => "gWm74b2i1Eutf8mb4"
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        echo $response;
    } elseif ($action === 'login') {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'student';

        $url = './api/users/login.php?auth_key=gWm74b2i1Eutf8mb4';
        $data = [
            'email' => $email,
            'password' => $password,
            'role' => $role,
            'auth_key' => "gWm74b2i1Eutf8mb4"
        ];

        $options = [
            'http' => [
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data)
            ]
        ];
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        echo $response;
    }
} else {
    echo 'Invalid request method.';
}
?>
