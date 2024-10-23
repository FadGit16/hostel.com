<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "User is not logged in.";
    exit();
}

$user_email = $_SESSION['email'];

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meal_type = $_POST['meal_type'];
    $quantity = $_POST['quantity'];

    if (!empty($meal_type) && !empty($quantity)) {
        $stmt = $conn->prepare("INSERT INTO orders (meal_type, quantity, user_email) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $meal_type, $quantity, $user_email); 

        
        if ($stmt->execute()) {
            
            echo "<script>
                    alert('Order placed successfully!');
                    window.location.href = 'Hosteller_portal.php';
                  </script>";
        } else {
            
            echo "Error: " . $stmt->error;
        }

        
        $stmt->close();
    } else {
        echo "Please provide both meal type and quantity.";
    }
}


$conn->close();
?>
