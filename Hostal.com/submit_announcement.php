    <?php
include('db_connection.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $announcement = isset($_POST['announcement']) ? $_POST['announcement'] : null;  

    // Check if the announcement is not empty
    if (!empty($announcement)) {
        // Prepare the SQL query
        $stmt = $conn->prepare("INSERT INTO announcements (notice) VALUES (?)");
        $stmt->bind_param("s", $announcement);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "<script>
                        alert('Announcement submitted successfully.');
                        window.location.href = 'admin.php'; // Redirect to admin.php
                      </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Please enter an announcement.";
    }
}


$conn->close();
?>
