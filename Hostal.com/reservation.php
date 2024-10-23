<?php
session_start(); 

include('db_connection.php');

// Function to check room availability
function isRoomAvailable($roomNumber) {
    global $conn;
    $query = "SELECT * FROM bookings WHERE room_number = ? AND status = 'booked'";
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
    // Single Rooms (1-10)
    '1' => 'Single Room', '2' => 'Single Room', '3' => 'Single Room',
    '4' => 'Single Room', '5' => 'Single Room', '6' => 'Single Room',
    '7' => 'Single Room', '8' => 'Single Room', '9' => 'Single Room',
    '10' => 'Single Room',

    // Sharing Rooms (11-20 with two beds each)
    '11-A' => 'Sharing Room (Bed 1)', '11-B' => 'Sharing Room (Bed 2)',
    '12-A' => 'Sharing Room (Bed 1)', '12-B' => 'Sharing Room (Bed 2)',
    '13-A' => 'Sharing Room (Bed 1)', '13-B' => 'Sharing Room (Bed 2)',
    '14-A' => 'Sharing Room (Bed 1)', '14-B' => 'Sharing Room (Bed 2)',
    '15-A' => 'Sharing Room (Bed 1)', '15-B' => 'Sharing Room (Bed 2)',
    '16-A' => 'Sharing Room (Bed 1)', '16-B' => 'Sharing Room (Bed 2)',
    '17-A' => 'Sharing Room (Bed 1)', '17-B' => 'Sharing Room (Bed 2)',
    '18-A' => 'Sharing Room (Bed 1)', '18-B' => 'Sharing Room (Bed 2)',
    '19-A' => 'Sharing Room (Bed 1)', '19-B' => 'Sharing Room (Bed 2)',
    '20-A' => 'Sharing Room (Bed 1)', '20-B' => 'Sharing Room (Bed 2)',

    // Dormitory Slots (1-20)
    'Slot 1' => 'Dormitory', 'Slot 2' => 'Dormitory', 'Slot 3' => 'Dormitory',
    'Slot 4' => 'Dormitory', 'Slot 5' => 'Dormitory', 'Slot 6' => 'Dormitory',
    'Slot 7' => 'Dormitory', 'Slot 8' => 'Dormitory', 'Slot 9' => 'Dormitory',
    'Slot 10' => 'Dormitory', 'Slot 11' => 'Dormitory', 'Slot 12' => 'Dormitory',
    'Slot 13' => 'Dormitory', 'Slot 14' => 'Dormitory', 'Slot 15' => 'Dormitory',
    'Slot 16' => 'Dormitory', 'Slot 17' => 'Dormitory', 'Slot 18' => 'Dormitory',
    'Slot 19' => 'Dormitory', 'Slot 20' => 'Dormitory',
];

// Initialize arrays to track availability and booking status
$availability = [];
$bookingStatus = [];
foreach ($rooms as $roomNumber => $roomType) {
    $availability[$roomNumber] = isRoomAvailable($roomNumber);
    $bookingStatus[$roomNumber] = isRoomBooked($roomNumber);
}

// Check if a booking has been made
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $roomNumber = $_POST['roomNumber'];
    $roomType = $_POST['roomType'];
    $duration = $_POST['duration'];
    $cardholderName = $_POST['cardholderName'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];
    $amount = $_POST['amount'];

    // Check if the room is still available
    if (isRoomAvailable($roomNumber)) {
        // Prepare SQL statement to insert booking
        $stmt = $conn->prepare("INSERT INTO bookings (room_number, room_type, duration, cardholder_name, card_number, expiry_date, cvv, amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'booked')");
        $stmt->bind_param("ssissssd", $roomNumber, $roomType, $duration, $cardholderName, $cardNumber, $expiryDate, $cvv, $amount);
        
        if ($stmt->execute()) {
            // Show a success message with JavaScript alert
            $_SESSION['bookingSuccess'] = true; // Set session variable
            echo "<script>
                    alert('Booking confirmed for Room $roomNumber ($roomType). Payment has been processed successfully.');
                    window.location.href = 'Hosteller_portal.php'; // Redirect to the same page
                  </script>";
        } else {
            // Show an error message if the booking failed
            echo "<script>alert('There was an error processing your booking. Please try again.');</script>";
        }

        $stmt->close();
    } else {
        // If room is no longer available
        echo "<script>alert('Room $roomNumber is no longer available. Please select another room.');</script>";
    }
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
    background-color: #f4f4f4; 
}

.container {
    text-align: center;
    margin: 20px auto;
}

.floor {
    display: flex;
    flex-wrap: wrap;
}

.room {
    width: 100px;
    margin: 10px;
    text-align: center;
}

.popup-form {
    display: none; 
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 15px;
    background-color: white;
    border: 2px solid #041425;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
    z-index: 1000;
    width: 400px; 
    height: 70vh; 
    overflow-y: auto; 
}

.popup-form input,
.popup-form select {
    width: 90%;
    margin-bottom: 12px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
}

.popup-form button {
    width: 90%;
    padding: 10px;
    background-color: #041425;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.popup-form button:hover {
    background-color: #33475b; 
}


.close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: none;
    border: none;
    font-size: 16px;
    font-weight: bold;
    color: #041425;
    cursor: pointer;
}

.close-btn:hover {
    color: red; 
}

</style>
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
    <?php foreach (range(11, 20) as $roomNumber): ?>
        <div class="room">
            <p>Room <?php echo $roomNumber; ?> - Bed 1</p>
            <?php 
                $bed1 = $roomNumber . '-A'; 
                if ($bookingStatus[$bed1]): 
            ?>
                <button disabled>Booked</button>
            <?php elseif ($availability[$bed1]): ?>
                <button class="booking-button" onclick="openBookingForm('<?php echo $bed1; ?>', 'Sharing Room - Bed 1')">Book Bed 1</button>
            <?php else: ?>
                <button disabled>Booked</button>
            <?php endif; ?>

            <p>Room <?php echo $roomNumber; ?> - Bed 2</p>
            <?php 
                $bed2 = $roomNumber . '-B'; 
                if ($bookingStatus[$bed2]): 
            ?>
                <button disabled>Booked</button>
            <?php elseif ($availability[$bed2]): ?>
                <button class="booking-button" onclick="openBookingForm('<?php echo $bed2; ?>', 'Sharing Room - Bed 2')">Book Bed 2</button>
            <?php else: ?>
                <button disabled>Booked</button>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>

        <!-- 3rd Floor (Dormitory) -->
        <h2>3rd Floor (Dormitory)</h2>
        <div class="floor">
            <?php foreach (['Slot 1', 'Slot 2', 'Slot 3', 'Slot 4','Slot 5','Slot 6','Slot 7','Slot 8','Slot 9','Slot 10','Slot 11',
            'Slot 12','Slot 13','Slot 14','Slot 15','Slot 16','Slot 17','Slot 18','Slot 19','Slot 20',] as $roomNumber): ?>
                <div class="room">
                    <p><?php echo $roomNumber; ?></p>
                    <?php if ($bookingStatus[$roomNumber]): ?>
                        <button disabled>Booked</button>
                    <?php elseif ($availability[$roomNumber]): ?>
                        <button class="booking-button" onclick="openBookingForm('<?php echo $roomNumber; ?>', 'Dormitory')">Book</button>
                    <?php else: ?>
                        <button disabled>Booked</button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pop-up Form -->
    <div class="popup-form" id="popupForm">
        <form method="POST">
            <h2>Booking Information</h2>
            <label for="roomNumber">Room Number:</label>
            <input type="text" id="roomNumber" name="roomNumber" readonly />

            <label for="roomType">Room Type:</label>
            <input type="text" id="roomType" name="roomType" readonly />

            <label for="duration">Duration:</label>
            <select id="duration" name="duration">
                <option value="3">3 months</option>
                <option value="6">6 months</option>
                <option value="9">9 months</option>
                <option value="12">1 year</option>
                <option value="18">1 and half year</option>
                <option value="24">2 years</option>
            </select>

            <h2>Payment Information</h2>
            <label for="cardholderName">Cardholder Name:</label>
            <input type="text" id="cardholderName" name="cardholderName" required />

            <label for="cardNumber">Card Number:</label>
            <input type="text" id="cardNumber" name="cardNumber" maxlength="16" required />

            <label for="expiryDate">Expiry Date (MM/YY):</label>
            <input type="text" id="expiryDate" name="expiryDate" maxlength="5" required />

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" required />

            <label for="amount">Reservation Amount:</label>
            <input type="text" id="amount" name="amount" readonly value="5000" />

            <button type="submit">Confirm Booking</button>
        </form>
        <button onclick="closeBookingForm()">Close</button>
    </div>

    <script>
        // Open booking form with pre-filled data
        function openBookingForm(roomNumber, roomType) {
            document.getElementById("roomNumber").value = roomNumber;
            document.getElementById("roomType").value = roomType;
            document.getElementById("popupForm").style.display = "block";
        }

        // Close booking form
        function closeBookingForm() {
            document.getElementById("popupForm").style.display = "none";
        }

        // Disable all booking buttons after successful booking
        function disableAllBookingButtons() {
            const buttons = document.querySelectorAll('.booking-button');
            buttons.forEach(button => {
                button.disabled = true;
                button.innerText = 'booked'; // Change button text to 'Unavailable'
            });
        }

        // Check if booking was successful
        <?php if (isset($_SESSION['bookingSuccess']) && $_SESSION['bookingSuccess']): ?>
            disableAllBookingButtons(); // Disable all buttons
            <?php unset($_SESSION['bookingSuccess']); // Clear the session variable ?>
        <?php endif; ?>

        // Check room booking status on page load
window.onload = function() {
    for (let roomNumber in roomBookingStatus) {
        if (roomBookingStatus[roomNumber]) {
            const button = document.querySelector(`.booking-button[data-room="${roomNumber}"]`);
            if (button) {
                button.disabled = true;
                button.innerText = 'booked';
            }
        }
    }
}

    </script>
</body>
</html>
