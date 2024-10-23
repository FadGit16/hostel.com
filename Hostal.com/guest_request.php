<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "User is not logged in.";
    exit();
}

$user_email = $_SESSION['email'];

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $guest_name = mysqli_real_escape_string($conn, $_POST['guest_name']);
    $guest_date = mysqli_real_escape_string($conn, $_POST['guest_date']);

    $sql = "INSERT INTO guest_requests (guest_name, guest_date, user_email) VALUES ('$guest_name', '$guest_date', '$user_email')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                        alert('Guest request submitted successfully!');
                        window.location.href = 'Hosteller_portal.php';
                    </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
