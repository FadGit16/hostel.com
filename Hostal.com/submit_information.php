<?php
include('db_connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $information = $_POST['information'] ?? '';  

    
    if (!empty($information)) {
        
        $stmt = $conn->prepare("INSERT INTO information (notice) VALUES (?)");
        $stmt->bind_param("s", $information);
        
        
        if ($stmt->execute()) {
            echo "<script>
                        alert('Information submitted successfully.');
                        window.location.href = 'admin.php'; // Redirect to admin.php
                      </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        
        $stmt->close();
    } else {
        echo "Please enter the information.";
    }
}


$conn->close();
?>
