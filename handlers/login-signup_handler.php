<?php
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Get action from POST data
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Determine which API to call based on action
    if ($action === 'signup') {
        handleSignup();
    } elseif ($action === 'login') {
        handleLogin();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

function handleSignup() {
    $url = 'http://localhost/virtual_uni/api/users/create.php';

    // Send the POST request to the signup API
    $response = makeApiRequest($url);

    // Process the response from the signup API
    if ($response['message'] === 'User created successfully.') {
        echo json_encode(['success' => true, 'message' => $response['message'], 'redirect_url' => 'dashboard.php']);
    } else {
        echo json_encode(['success' => false, 'message' => $response['message']]);
    }
}

function handleLogin() {
    $url = 'http://localhost/virtual_uni/api/users/login.php'; 

    // Send the POST request to the login API
    $response = makeApiRequest($url);

    // Process the response from the login API
    if ($response['message'] === 'Login successful.') {
        echo json_encode(['success' => true, 'message' => $response['message'], 'redirect_url' => 'dashboard.php']);
    } else {
        echo json_encode(['success' => false, 'message' => $response['message']]);
    }
}

function makeApiRequest($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));

    $response = curl_exec($ch);

    if ($response === false) {
        return ['message' => 'Error: ' . curl_error($ch)];
    }

    curl_close($ch);
    return json_decode($response, true);
}
