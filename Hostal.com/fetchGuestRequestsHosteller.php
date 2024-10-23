<?php
include('db_connection.php'); 

$sql = "SELECT user_email, guest_name, status FROM guest_requests";
$result = mysqli_query($conn, $sql);

$guestRequests = array();

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $guestRequests[] = $row;
    }
    echo json_encode($guestRequests); 
} else {
    echo json_encode(["success" => false, "error" => mysqli_error($conn)]); 
}

mysqli_close($conn); 
?>
