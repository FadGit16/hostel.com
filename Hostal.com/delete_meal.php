<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if meal_type is provided
    if (isset($_POST['meal_type'])) {
        // Get the meal_type from the request
        $meal_type = $_POST['meal_type'];

        // Prepare the SQL statement to delete the meal
        $query = "DELETE FROM meals WHERE meal_type = ?";
        $stmt = $conn->prepare($query);

        // Bind parameters to avoid SQL injection
        $stmt->bind_param("s", $meal_type);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Meal deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error deleting meal."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Meal type not provided."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
