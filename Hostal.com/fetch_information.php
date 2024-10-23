<?php
include('db_connection.php');

$sql = "SELECT * FROM information ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $information = [];
    while($row = $result->fetch_assoc()) {
        $information[] = $row;
    }
    echo json_encode($information);
} else {
    echo json_encode([]);
}

$conn->close();
?>
