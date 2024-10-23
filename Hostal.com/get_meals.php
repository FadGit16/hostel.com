<?php
include('db_connection.php');

$query = "SELECT meal_type, time_start, time_end FROM meals";
$result = $conn->query($query);

$meals = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meals[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($meals);

if (isset($conn)) {
    $conn->close();
}
?>
