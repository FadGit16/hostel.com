<?php
session_start();
include('db_connection.php');
require 'Mail/phpmailer/PHPMailerAutoload.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Registration process
    if (isset($_POST['full_name'])) {
        $full_name = $conn->real_escape_string($_POST['full_name']);
        $address = $conn->real_escape_string($_POST['address']);
        $NIC = $conn->real_escape_string($_POST['NIC']);
        $contact_num = $conn->real_escape_string($_POST['contact_num']);
        $dob = $conn->real_escape_string($_POST['dob']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirmPassword = $conn->real_escape_string($_POST['confirmPassword']);
        $terms = isset($_POST['terms']) ? 1 : 0;

        if ($password !== $confirmPassword) {
            echo "<script>alert('Passwords do not match!');</script>";
            exit();
        }

        // Check if the email already exists
        $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('Email already registered!');</script>";
            exit();
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (full_name, address, NIC, contact_num, dob, email, password, terms) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $full_name, $address, $NIC, $contact_num, $dob, $email, $hashedPassword, $terms); 

        echo "Full Name: $full_name, Email: $email, Hashed Password: $hashedPassword, Terms: $terms";

        if ($stmt->execute()) {
            // OTP generation
            $otp = rand(100000, 999999); // Generate a random OTP
            $_SESSION['otp'] = $otp; // Store OTP in session
            $_SESSION['mail'] = $email; // Store email in session

            // Sending OTP email using PHPMailer
            $mail = new PHPMailer;
            $mail->SMTPDebug = 0; // Set to 2 for debugging
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl';
            $mail->Username = 'hostelcom37@gmail.com'; // Your Gmail address
            $mail->Password = 'becy zpsm buwj xqas'; // Your Gmail App password
            $mail->setFrom('hostelcom37@gmail.com', 'OTP Verification');
            $mail->addAddress($email); // Send the email to the registered email address

            $mail->isHTML(true);
            $mail->Subject = "Your verification code";
            $mail->Body = "<p>Dear user,</p><h3>Your verification OTP code is $otp</h3><br><p>With regards,</p><b>Hyper Zone Management</b>";

            if (!$mail->send()) {
                $error_message = "Mailer Error: " . $mail->ErrorInfo;
                echo "<script>alert('$error_message');</script>";
            } else {
                echo "<script>alert('Register Successfully, OTP sent to $email'); window.location.replace('OTP.php');</script>";
            }
        } else {
            echo "Error: " . $stmt->error;
        }
    } 
    
    // Login process
    if (isset($_POST['login_email'])) {
        $email = $conn->real_escape_string($_POST['login_email']);
        $password = $conn->real_escape_string($_POST['login_password']);

        if ($email === 'admin@gmail.com' && $password === 'admin') {
            header("Location: admin.php");
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $row = $result->fetch_assoc();
                
                // Verify the password
                if (password_verify($password, $row['password'])) {
                    $_SESSION['email'] = $row['email']; 
                    header("Location: home.php");
                    exit();
                } else {
                    $error_message = "Invalid password.";
                }
            } else {
                $error_message = "No user found with that email.";
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login/Signup</title>
    <link rel="stylesheet" href="Login_Signup.css">
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-in-container">
            <form method="POST" action="Login_Signup.php">
                <h1>Log In</h1>
                <input type="email" name="login_email" id="login_email" value="<?php echo isset($_POST['login_email']) ? htmlspecialchars($_POST['login_email']) : ''; ?>" placeholder="Email" required>
                <br>
                <!-- Display email error -->
                <?php if (isset($error_message) && strpos($error_message, 'email') !== false) { ?>
                    <span class="error"><?php echo $error_message; ?></span>
                <?php } ?>
                <br>
                <input type="password" name="login_password" placeholder="Password" required />
                <!-- Display password error -->
                <?php if (isset($error_message) && strpos($error_message, 'password') !== false) { ?>
                    <span class="error"><?php echo $error_message; ?></span>
                <?php } ?>
                <br><br>
                <?php if (isset($error_message) && strpos($error_message, 'Invalid') === 0) {
                    echo "<p style='color:red;'>$error_message</p>";
                } ?>
                <br>
                <button>Log In</button>
            </form>
        </div>

        <div class="form-container sign-up-container">
            <form id="signupForm" method="POST" action="Login_Signup.php">
                <h1>Create Account</h1>
                <div class="step active">
                    <input type="text" id="fullName" name="full_name" placeholder="Full Name" required />
                    <input type="text" id="address" name="address" placeholder="Address" required />
                    <input type="text" id="NIC" name="NIC" placeholder="NID/Passport ID Number" required />
                    <input type="tel" id="contact_num" name="contact_num" placeholder="Phone Number" required />
                    <input type="date" id="dob" name="dob" required />
                    <button type="button" id="nextButton">Next</button>
                </div>

                <div class="step">
                    <input type="email" id="email" name="email" placeholder="Email Address" required />
                    <input type="password" id="password" name="password" placeholder="Password" required />
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required />
                    <label for="terms">
                        <input type="checkbox" id="terms" name="terms" required /> terms and conditions
                    </label>
                    <input type="submit" value="Signup" />
                </div>
            </form>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>Please Log in to continue</p>
                    <button class="ghost" id="signIn">Log In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello hosteller..!</h1>
                    <p>Enter your details to start your journey with us!</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="Login_Signup.js"></script>
</body>
</html>
