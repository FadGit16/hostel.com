<?php
header('Content-Type: application/json');

include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['user_email'])) {
        $userEmail = $data['user_email'];

        $stmt = $conn->prepare("DELETE FROM reviews WHERE user_email = ?");
        $stmt->bind_param("s", $userEmail);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No review found with that email.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting review.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
