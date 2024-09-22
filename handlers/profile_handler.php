<?php
// profile_handler.php
if($_GET['action'] ?? "" == "update") {
    // Collect form data
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : null;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;
    $bio = isset($_POST['bio']) ? $_POST['bio'] : null; 

    // Handle profile picture if uploaded
    $profile_picture = null;
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = '../profile/'; // Path for uploads
        $profile_picture_name = time() . '_' . basename($_FILES['profile_picture']['name']);
        $profile_picture_path = $upload_dir . $profile_picture_name;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture_path)) {
            $profile_picture = './profile/' . $profile_picture_name;
        }
    }

    session_start() ; 
    $_SESSION['username'] = $username ; 

    // Prepare data for the API request
    $postData = [
        'user_id' => $user_id,
        'username' => $username,
        'first_name' => $first_name,
        'last_name' => $last_name,
        'role' => $role,
        'bio' => $bio,
        'profile_picture' => $profile_picture
    ];

    // Send the data to the API via cURL
    $apiUrl = 'http://localhost/virtual_uni/api/users/update.php';
    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    
    // Execute the request
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check response status
    if ($httpcode == 200) {
        echo $response; // Return the API's response back to the front-end
    } else {
        echo json_encode(['message' => 'Failed to connect to the API']);
    }

    exit; // Stop further execution
}
 




//FETCHING USER INFO TO DISPLAY 
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
