<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event = $_POST['event'] ?? '';  

    
    if (!empty($event)) {
        
        $stmt = $conn->prepare("INSERT INTO events (notice) VALUES (?)");
        $stmt->bind_param("s", $event);
        
        
        if ($stmt->execute()) {
            echo "<script>
            alert('Event submitted successfully.');
            window.location.href = 'admin.php'; // Redirect to admin.php
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        
        $stmt->close();
    } else {
        echo "Please enter an event.";
    }
}


$conn->close();
?>
