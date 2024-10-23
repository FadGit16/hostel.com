<?php
include('db_connection.php');

$sql = "SELECT * FROM events ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $events = [];
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
    echo json_encode($events);
} else {
    echo json_encode([]);
}

$conn->close();
?>
