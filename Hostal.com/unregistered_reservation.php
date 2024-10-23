<?php
session_start(); 

include('db_connection.php');

function isRoomAvailable($roomNumber) {
    global $conn;
    $query = "SELECT * FROM bookings WHERE room_number = ? AND status = 'unavailable'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $roomNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 0;
}

// Function to check if the room is booked
function isRoomBooked($roomNumber) {
    global $conn;
    $query = "SELECT * FROM bookings WHERE room_number = ? AND status = 'booked'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $roomNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Initialize rooms and their statuses
$rooms = [
    '1' => 'Single Room',
    '2' => 'Single Room',
    '3' => 'Single Room',
    '4' => 'Single Room',
    '5' => 'Single Room',
    '6' => 'Single Room',
    '7' => 'Single Room',
    '8' => 'Single Room',
    '9' => 'Single Room',
    '10' => 'Single Room',
    '11' => 'Sharing Room',
    '12' => 'Sharing Room',
    '13' => 'Sharing Room',
    '14' => 'Sharing Room',
    '15' => 'Sharing Room',
    '16' => 'Sharing Room',
    'Slot 1' => 'Dormitory',
    'Slot 2' => 'Dormitory',
    'Slot 3' => 'Dormitory',
    'Slot 4' => 'Dormitory'
];

$availability = [];
$bookingStatus = [];
foreach ($rooms as $roomNumber => $roomType) {
    $availability[$roomNumber] = isRoomAvailable($roomNumber);
    $bookingStatus[$roomNumber] = isRoomBooked($roomNumber);
}

// Close the connection after all processing is done
// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Room Booking</title>
    <link rel="stylesheet" href="reservation_hosteller.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin: center;
        }
        .floor {
            display: flex;
            flex-wrap: wrap;
        }
        .room {
            width: 100px;
            margin: 10px;
        }
        .popup-form {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: white;
            border: 2px solid #ccc;
            z-index: 1000;
        }
        .popup-form input,
        .popup-form select {
            width: 100%;
            margin-bottom: 10px;
            padding: 8px;
        }
        .popup-form button {
            padding: 10px;
            background-color: #4caf50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .popup-form button:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // Function to check if the user is logged in
        function isLoggedIn() {
            <?php if (!isset($_SESSION['user'])): ?>
                return false;
            <?php else: ?>
                return true;
            <?php endif; ?>
        }

        // Function to handle room booking
        function openBookingForm(roomNumber, roomType) {
            if (!isLoggedIn()) {
                alert('Log in first to book the room.');
                if (confirm('You need to log in to proceed with booking. Would you like to log in now?')) {
                    window.location.href = 'Login_Signup.php'; // Redirect to the login page
                }
            } else {
                // Proceed with booking form (your existing booking form logic)
                // ...
                // You can open the booking form modal here
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Hostel Reservation</h1>
        
        <!-- 1st Floor (Single Rooms) -->
        <h2>1st Floor (Single Rooms)</h2>
        <div class="floor">
            <?php foreach (range(1, 10) as $roomNumber): ?>
                <div class="room">
                    <p>Room <?php echo $roomNumber; ?></p>
                    <?php if ($bookingStatus[$roomNumber]): ?>
                        <button disabled>Booked</button>
                    <?php elseif ($availability[$roomNumber]): ?>
                        <button class="booking-button" onclick="openBookingForm('<?php echo $roomNumber; ?>', 'Single Room')">Book</button>
                    <?php else: ?>
                        <button disabled>Booked</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 2nd Floor (Sharing Rooms) -->
        <h2>2nd Floor (Sharing Rooms)</h2>
        <div class="floor">
            <?php foreach (range(11, 16) as $roomNumber): ?>
                <div class="room">
                    <p>Room <?php echo $roomNumber; ?></p>
                    <?php if ($bookingStatus[$roomNumber]): ?>
                        <button disabled>Unavailable</button>
                    <?php elseif ($availability[$roomNumber]): ?>
                        <button class="booking-button" onclick="openBookingForm('<?php echo $roomNumber; ?>', 'Sharing Room')">Book</button>
                    <?php else: ?>
                        <button disabled>Booked</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 3rd Floor (Dormitory) -->
        <h2>3rd Floor (Dormitory)</h2>
        <div class="floor">
            <?php foreach (['Slot 1', 'Slot 2', 'Slot 3', 'Slot 4'] as $roomNumber): ?>
                <div class="room">
                    <p><?php echo $roomNumber; ?></p>
                    <?php if ($bookingStatus[$roomNumber]): ?>
                        <button disabled>Unavailable</button>
                    <?php elseif ($availability[$roomNumber]): ?>
                        <button class="booking-button" onclick="openBookingForm('<?php echo $roomNumber; ?>', 'Dormitory')">Book</button>
                    <?php else: ?>
                        <button disabled>Booked</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</body>
</html>
