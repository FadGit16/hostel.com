<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mealType = isset($_POST['mealType']) ? $_POST['mealType'] : null;
    $timeStart = isset($_POST['timeStart']) ? $_POST['timeStart'] : null;
    $timeEnd = isset($_POST['timeEnd']) ? $_POST['timeEnd'] : null;

    if ($mealType && $timeStart && $timeEnd) {
        $stmt = $conn->prepare("INSERT INTO meals (meal_type, time_start, time_end) VALUES (?, ?, ?)");
        
        if ($stmt) { 
            $stmt->bind_param("sss", $mealType, $timeStart, $timeEnd);

            if ($stmt->execute()) {
                echo "<script>
                        alert('New meal added successfully!');
                        window.location.href = 'admin.php'; // Redirect to admin.php
                      </script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Please fill all fields.";
    }
    
}

if (isset($conn)) {
    $conn->close();
}
?>
