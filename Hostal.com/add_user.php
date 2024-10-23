
<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $address = $conn->real_escape_string($_POST['address']);
    $NIC = $conn->real_escape_string($_POST['NIC']);
    $contact_num = $conn->real_escape_string($_POST['contact_num']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $profile_picture = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; 
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Check file type
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $profile_picture = $target_file; 
            } else {
                echo json_encode(['success' => false, 'message' => 'Error uploading file.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
            exit;
        }
    } else {
        // Handle file upload error
        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'File upload error: ' . $_FILES["image"]["error"]]);
            exit;
        }
    }

    // Inserting data into the user data into the database
    $sql = "INSERT INTO users (full_name, address, NIC, contact_num, dob, email, password, image) 
            VALUES ('$full_name', '$address', '$NIC', '$contact_num', '$dob', '$email', '$hashedPassword', '$profile_picture')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error . ' SQL: ' . $sql]);
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="add_user.css">
</head>
<body>
<div class="card">
    <h3>Add User</h3>
    <form id="add-user-form" class="user-form" method="POST" enctype="multipart/form-data" onsubmit="handleAddUser(event)">
        <div class="profile-picture-upload">
            <img src="https://via.placeholder.com/150" alt="Profile Picture" id="profile-picture">
            <br>
            <label for="image">Upload Profile Picture:</label>
            <input type="file" id="image" name="image" accept="image/*" onchange="previewProfilePicture(event)">
        </div>
        
        <label for="full-name">Full Name:</label>
        <input type="text" id="full-name" name="full_name" required>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>

        <label for="NIC">NIC/Passport Number:</label>
        <input type="text" id="NIC" name="NIC" required>

        <label for="contact_num">Mobile Number:</label>
        <input type="text" id="contact_num" name="contact_num" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Add User</button>
    </form>
</div>
<script>
    function previewProfilePicture(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const img = document.getElementById('profile-picture');
            img.src = e.target.result; 
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    function handleAddUser(event) {
    event.preventDefault(); // Prevent the form from submitting the traditional way
    const formData = new FormData(event.target); // Creating a FormData object from the form

    
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('add-user-form').reset(); 
            document.getElementById('profile-picture').src = 'https://via.placeholder.com/150'; 
            alert('User added successfully!'); 
            window.location.href = 'admin.php'; 
        } else {
            alert('Failed to add user: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('There was an error adding the user.');
    });
}

</script>
</body>
</html>
