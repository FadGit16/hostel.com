<?php
header('Content-Type: application/json');

include('db_connection.php');

// Get the request body
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['user_email'])) {
    $user_email = $conn->real_escape_string($data['user_email']);

    $sql = "DELETE FROM `orders` WHERE `user_email` = '$user_email'";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting record: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
}

$conn->close();
?>