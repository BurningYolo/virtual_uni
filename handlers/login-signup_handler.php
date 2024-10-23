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
    //echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

function handleSignup() {
    $url = 'http://localhost/virtual_uni/api/users/create.php';

    // Send the POST request to the signup API
    $response = makeApiRequest($url);

    // Check if the response is valid and contains a message
    if (isset($response['message'])) {
        if ($response['message'] === 'User created successfully.') {
            echo json_encode(['success' => true, 'message' => 'Account created successfully.', 'action' => 'signup']);
        } else {
            echo json_encode(['success' => false, 'message' => $response['message']]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Unexpected response from server.']);
    }
}

function handleLogin() {
    $url = 'http://localhost/virtual_uni/api/users/login.php'; 

    // Send the POST request to the login API
    $response = makeApiRequest($url);

    // Check if the response is valid and contains a message
    if (isset($response['message'])) {
        if ($response['message'] === 'Login successful.') {
            // Check if user details are present in the response
            if (isset($response['user_details'])) {
                // Set session variables
                session_start();
                $_SESSION['email'] = $response['user_details']['email'];
                $_SESSION['role'] = $response['user_details']['role'];
                $_SESSION['user_id'] = $response['user_details']['user_id'];
                $_SESSION['username'] = $response['user_details']['username'];

                // Send a successful response with additional login action
                echo json_encode([
                    'success' => true, 
                    'message' => 'Login successful.', 
                    'action' => 'login'
                ]);
            } else {
                // If user details are missing, handle it as an error
                echo json_encode([
                    'success' => false, 
                    'message' => 'User details not found in response.'
                ]);
            }
        } else {
            // Send an error response if login fails
            echo json_encode([
                'success' => false, 
                'message' => $response['message']
            ]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Unexpected response from server.']);
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
    //print_r($response); 

    $decodedResponse = json_decode($response, true);

    // Ensure the response is valid JSON


    return $decodedResponse;
}
