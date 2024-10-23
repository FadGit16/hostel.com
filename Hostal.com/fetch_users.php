<?php
include('db_connection.php');

$query = "SELECT id, full_name, email FROM users"; 
$result = mysqli_query($conn, $query);

$users = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
    echo json_encode($users);
} else {
    echo json_encode([]);
}
?>
