<?php

include('db_connection.php');

$sql = "SELECT user_email, review_text, rating FROM reviews";
$result = $conn->query($sql);

$reviews = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}

echo json_encode($reviews);
?>