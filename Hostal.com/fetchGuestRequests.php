<?php
header('Content-Type: application/json'); 

include('db_connection.php'); 

$sql = "SELECT user_email, guest_name, guest_date FROM guest_requests";
$result = mysqli_query($conn, $sql);

$guest_requests = []; 

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $guest_requests[] = $row; 
    }
    echo json_encode($guest_requests); 
} else {
    echo json_encode(["error" => "Query error: " . mysqli_error($conn)]);
}

mysqli_close($conn); 
?>
