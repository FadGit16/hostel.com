<?php

include('db_connection.php');

$sql = "SELECT `user_email`, `meal_type`, `quantity` FROM `orders`";
$result = $conn->query($sql);


$orders = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}


echo json_encode($orders);


$conn->close();
?>
