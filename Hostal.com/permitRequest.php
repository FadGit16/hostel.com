<?php
session_start(); 
include('db_connection.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email of the user whose request is being permitted
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);

    // Prepare the SQL query to update the guest request status
    $sql = "UPDATE guest_requests SET status = 'permitted' WHERE user_email = '$user_email'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => mysqli_error($conn)]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}

mysqli_close($conn); 
?>
