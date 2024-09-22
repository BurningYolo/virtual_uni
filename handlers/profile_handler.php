<?php
// profile_handler.php



//UPDATE BLOCK 
$action = $_GET['action'] ?? "" ; 
    
if($action == "update")
{
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'email' => $_POST['email'],
        'bio' => $_POST['bio']
    ];

    // Set up cURL for the update request
    $curl = curl_init('http://localhost/virtual_uni/api/users/update/');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

    // Execute the request and handle response
    $response = curl_exec($curl);

    if ($response === false) {
        die(json_encode(['success' => false, 'message' => curl_error($curl)]));
    }

    curl_close($curl);

    // Handle the API response
    $result = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die(json_encode(['success' => false, 'message' => 'Error decoding API response.']));
    }

    // Return the result to the AJAX request
    echo json_encode($result);
}





//USER INFO GET


// Check if the user is logged in
if (isset($_SESSION['user_id'])) {

    // Define the API endpoint
    $apiUrl = 'http://localhost/virtual_uni/api/users/';




    // Initialize cURL
    $curl = curl_init($apiUrl);

    // Set cURL options
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL request
    $response = curl_exec($curl);

    // Check for errors
    if ($response === false) {
        die('Error fetching user data: ' . curl_error($curl));
    }

    // Close the cURL session
    curl_close($curl);

    // Decode the JSON response
    $users = json_decode($response, true);

    // Check if user data was retrieved
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Error decoding JSON response.');
    }

    // Find the specific user by ID
    $user = null;
    foreach ($users as $u) {
        if ($u['user_id'] == $_SESSION['user_id']) {
            $user = $u;
            break;
        }
    }

    // Check if the user was found
    if ($user === null) {
        die('User not found.');
    }
} else {
    // Redirect or handle unauthorized access
    die('User not logged in.');
}
?>
