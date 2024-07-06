<?php
// Include necessary files
include "../../inc/header.php";
include "../../inc/nav.php";
include "../../inc/sidebar.php";
include "../../inc/functions.php";
$obj = new func();

// Check if ID parameter is set in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Assuming $obj is your object to interact with the database
    // Fetch user details by ID
    $user_details = $obj->getsingleuserdetails($id);
    
    // Check if user details were found
    if ($user_details) {
        var_dump($user_details);
        // Assuming $user_details is an array of user details
        echo '<table>';
        foreach ($user_details as $user) {
            echo '<tr>';
            echo '<td>User ID: ' . $user['id'] . '</td>';
            echo '<td>User Name: ' . $user['user_name'] . '</td>';
            echo '<td>User Mobile: ' . $user['user_mobile'] . '</td>';
            echo '<td>Water Hours: ' . $user['water_hours'] . '</td>';
            // Add more details as needed
            echo '</tr>';
        }
        echo '</table>';
        
        // Example: Display a link to go back
        echo '<p><a href="javascript:history.go(-1)">Go Back</a></p>';
    } else {
        echo '<p>User not found.</p>';
    }
} else {
    echo '<p>No user ID specified.</p>';
}

// Include footer file
include "../../inc/footer.php";
?>
