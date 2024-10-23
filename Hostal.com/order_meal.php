<?php
include 'db_connection.php'; 

$data = json_decode(file_get_contents('php://input'), true);

$meal_id = $data['meal_id'];
$meal_type = $data['meal_type'];
$quantity = $data['quantity'];

if (!empty($meal_id) && !empty($meal_type) && $quantity > 0) {
    // Insert the order into the orders table
    $stmt = $conn->prepare("INSERT INTO orders (meal_id, meal_type, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $meal_id, $meal_type, $quantity);
    
    if ($stmt->execute()) {
        
        echo json_encode(['success' => true]);
    } else {
        
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    
    echo json_encode(['success' => false, 'error' => 'Invalid input']);
}

$conn->close();
?>
