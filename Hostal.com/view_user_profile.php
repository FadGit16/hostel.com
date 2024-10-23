<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connection.php';

// Check if the user ID is provided in the query string
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prepare and execute SELECT query to fetch user profile
    $stmt = $conn->prepare("SELECT id, full_name, email, phone, address, dob FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo json_encode($user);
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch user profile.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
