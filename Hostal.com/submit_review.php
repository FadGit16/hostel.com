<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "User is not logged in.";
    exit();
}

$user_email = $_SESSION['email'];

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $review_text = $_POST['review-text'];
    $rating = $_POST['rating'];

    if (!empty($review_text) && !empty($rating)) {
        $stmt = $conn->prepare("INSERT INTO reviews (review_text, rating, user_email, hosteller_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $review_text, $rating, $user_email, $hosteller_name); // "si" indicates string and integer

            if ($stmt->execute()) {
                echo "<script>
                        alert('Review submitted successfully!');
                        window.location.href = 'Hosteller_portal.php';
                    </script>";
            } else {
                echo "Error: " . $stmt->error;
            }

        $stmt->close();
    } else {
        echo "Please provide both review text and a rating.";
    }
}

$conn->close();
?>
