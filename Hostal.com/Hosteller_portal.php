<?php 

session_start();
if (!isset($_SESSION['email'])) {
    echo "User is not logged in.";
    exit();
}

$email = $_SESSION['email'];

if (isset($_GET['email'])) {
    $email = $_GET['email']; 
}


include('db_connection.php');



$query = "SELECT image, full_name, address, dob, NIC, contact_num, email FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $query);

if ($result) {
    $user = mysqli_fetch_assoc($result);  
} else {
    echo "Error fetching user data: " . mysqli_error($conn);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full-name'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $nic = $_POST['NIC'];
    $contact_num = $_POST['contact_num'];
    $email = $_POST['email'];

 
$imageTargetPath = $user['image']; 

if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
    
    $image = $_FILES['image']['name'];
    $imageTmpPath = $_FILES['image']['tmp_name'];
    $imageTargetPath = 'uploads/' . basename($image);

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Move the uploaded file
    if (!move_uploaded_file($imageTmpPath, $imageTargetPath)) {
        echo "Error uploading the image.";
        exit();  
    }
}

$update_query = "UPDATE users SET 
                    full_name = '$full_name', 
                    address = '$address', 
                    dob = '$dob', 
                    NIC = '$nic', 
                    contact_num = '$contact_num', 
                    email = '$email', 
                    image = '$imageTargetPath' 
                WHERE email = '$email'";

if (mysqli_query($conn, $update_query)) {
    $_SESSION['message'] = "Profile updated successfully!";
} else {
    $_SESSION['message'] = "Error updating profile: " . mysqli_error($conn);
}


header("Location: Hosteller_portal.php");
exit();

}

if (isset($_SESSION['message'])) {
    echo '<script type="text/javascript">';
    echo 'alert("' . $_SESSION['message'] . '");';
    echo '</script>';
    unset($_SESSION['message']); 
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Portal - Hosteller Portal</title>
    <link rel="stylesheet" href="Hosteller_portal.css">
  </head>
  <body>
    
    <div class="sidebar">
      <h2>My Portal</h2>
      <ul>
        <li onclick="showContent('profile')">
          <i class="fa fa-user" aria-hidden="true"></i> My Profile
        </li>
        <li onclick="showContent('payment')">
          <i class="fa fa-credit-card" aria-hidden="true"></i> Payment Schedule
        </li>
        <li onclick="showContent('meal')">
          <i class="fa fa-cutlery" aria-hidden="true"></i> Meal
        </li>
        <li onclick="showContent('qr')">
          <i class="fa fa-qrcode" aria-hidden="true"></i> Get-in Get-out QR
        </li>
        <li onclick="showContent('guest')">
          <i class="fa fa-user-plus" aria-hidden="true"></i> Guest Permission
        </li>
        <li onclick="showContent('request')">
          <i class="fa fa-comment" aria-hidden="true"></i> Review
        </li>
        <li onclick="showContent('notice')">
          <i class="fa fa-bell" aria-hidden="true"></i> Notice Board
        </li>
        <li onclick="showContent('notifications')">
          <i class="fa fa-qrcode" aria-hidden="true"></i> Notifications
        </li>
        <li onclick="logout()">
          <i class="fa fa-bell" aria-hidden="true"></i> Logout
        </li> 
      </ul>
    </div>

    
    <div class="content" id="content">
      <h1>Welcome to your Portal</h1>
      <p>Enjoy Your Dream Hostel.</p>
    </div>

    
    <script
      src="https://kit.fontawesome.com/a076d05399.js"
      crossorigin="anonymous"
    ></script>

    <script>
      function showContent(section) {
                      let content = document.getElementById("content");
                      let htmlContent = "";

                      switch (section) {
                        case "profile":
                          htmlContent = `
                                      <div class="card">
                                          <h3>My Profile</h3>
                                            <form id="profile-form" class="profile-form" method="POST" enctype="multipart/form-data">
                                              <div class="profile-picture-upload">
                                                    <img src="<?php echo !empty($user['image']) ? $user['image'] : 'https://via.placeholder.com/150'; ?>" alt="Profile Picture" id="profile-picture">
                                                  <br>
                                                  <label for="image">Change Picture</label>
                                                    <input type="file" id="image" name="image" accept="image/*" onchange="previewProfilePicture(event)">
                                              </div>
                                              
                                              <label for="full-name">Full Name:</label>
                                              <input type="text" id="full-name" name="full-name" value="<?php echo $user['full_name']; ?>" required>

                                              <label for="address">Address:</label>
                                              <input type="text" id="address" name="address" value="<?php echo $user['address']; ?>" required>

                                              <label for="NIC">NIC/Passport Number:</label>
                                              <input type="text" id="NIC" name="NIC" value="<?php echo $user['NIC']; ?>" required>

                                              <label for="contact_num">Mobile Number:</label>
                                              <br>
                                              <input type="contact_num" id="contact_num" name="contact_num" value="<?php echo $user['contact_num']; ?>" required>
                                              <br>
                                              <br>

                                             <label for="dob">Date of Birth:</label>
                                             <input type="date" id="dob" name="dob" value="<?php echo $user['dob']; ?>" required>


                                              <label for="email">Email Address:</label>
                                              <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

                                              <button type="submit">Save Changes</button>
                                          </form>
                                      </div>`;
                          break;
                        case "payment":
                          htmlContent = `
                                      <div class="card">
                      <h3>Payment Schedule</h3>
                      <div class="tabs">
                          <button class="tab-button active" onclick="showTab('make-payment')">Make Payment</button>
                          <button class="tab-button" onclick="showTab('view-status')">View Payment Status</button>
                      </div>
                      <div id="make-payment" class="tab-content active">
                          <h4>Make a Payment</h4>
                          <form id="make-payment-form">
                              <label for="payment-amount">Amount:</label>
                          <input type="number" id="payment-amount" name="amount" placeholder="Enter amount" required>
                          <label for="payment-date">Date:</label>
                          <input type="date" id="payment-date" name="date" required>
                          <button type="submit" class="payment-button">Submit Payment</button>
                      </form>
                      <p><strong>Admin Note:</strong> Payments are processed by the admin. Ensure correct amount and date are entered.</p>
                  </div>
                  <div id="view-status" class="tab-content">
                      <h4>Payment Status</h4>
                      <p><strong>Last Payment:</strong> $500 on 01/09/2024</p>
                      <p><strong>Next Payment Due:</strong> $500 on 01/10/2024</p>
                      <p><strong>Status:</strong> Up-to-date</p>
                      <p><strong>Admin Note:</strong> Payment status is updated by the admin.</p>
                  </div>
              </div>`;
                          break;
                          case "meal":
                                htmlContent = `
                                    <div class="card">
                                        <h3>Meal</h3>
                                        <p>Select your meals for today:</p>
                                        <form id="mealOrderForm" method="POST">
                                            <table class="meal-table">
                                                <thead>
                                                    <tr>
                                                        <th>Meal Type</th>
                                                        <th>Start time</th>
                                                        <th>End time</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="mealTableBody">
                                                </tbody>
                                            </table>
                                        </form>
                                      <form method="POST" action="save_order.php">
                                        <table class="meal-table">
                                            <thead>
                                                <tr>
                                                    <th>Meal Type</th>
                                                    <th>Quantity</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="meal_type" placeholder="Enter meal type" required />
                                                    </td>
                                                    <td>
                                                        <input type="number" name="quantity" placeholder="Enter quantity" required />
                                                    </td>
                                                    <td>
                                                        <button type="submit">Order</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>

                                        </div>`;
                                fetchMeals(); 
                                break;

                        case "qr":
                          htmlContent = `
                                  <div class="card">
                  <h3>Get-in Get-out QR</h3>
                  <div class="qr-container">
                      <p>Your QR code for easy check-ins and check-outs:</p>
                      <div id="qr-display">
                          <!-- Placeholder for QR code image -->
                          <img src="https://via.placeholder.com/200" alt="QR Code" id="qr-code-image">
                      </div>
                      <p><strong>Admin Note:</strong> The QR code is provided or auto-generated by the admin.</p>
                  </div>
              </div>`;
                          break;  
                        case "guest":
                          htmlContent = `
                                      <div class="card">
                                          <h3>Guest Permission</h3>
                                          <p>Request permission for guest visits:</p>
                                          <form method="POST" action="guest_request.php">
                                              <label for="guest-name">Guest Name:</label><br>
                                              <input type="text" id="guest-name" name="guest_name" required><br><br>
                                              <label for="guest-date">Visit Date:</label><br>
                                              <input type="date" id="guest-date" name="guest_date" required><br><br>
                                              <button type="submit">Submit Request</button>
                                          </form>
                                          <p><strong>Admin Note:</strong> All guest permissions are approved by the admin.</p>
                                      </div>`;
                          break;
                        case "request":
                          htmlContent = `
                                    <div class="card">
                  <h3>Review</h3>
                  <div class="review-section">
                      <h4>Submit Your Review</h4>
                      <form id="review-form" method="POST" action="submit_review.php">
                          <label for="review-text">Your Review:</label>
                          <textarea id="review-text" name="review-text" rows="4" cols="50" required></textarea><br><br>
                          <label for="rating">Rating:</label>
                          <div class="rating">
                              <input type="radio" id="star5" name="rating" value="5"><label for="star5">&#9733;</label>
                              <input type="radio" id="star4" name="rating" value="4"><label for="star4">&#9733;</label>
                              <input type="radio" id="star3" name="rating" value="3"><label for="star3">&#9733;</label>
                              <input type="radio" id="star2" name="rating" value="2"><label for="star2">&#9733;</label>
                              <input type="radio" id="star1" name="rating" value="1"><label for="star1">&#9733;</label>
                          </div><br><br>
                          <button type="submit" class="review-button">Submit Review</button>
                      </form>
                  </div>
              </div>`;
                          break;
                        case "notice":
                          htmlContent = `
                                    <!-- Notice Board Content -->
              <div class="card">
                  <h3>Notice Board</h3>
                  <div class="notice-board">
                      <div>
                        <h3>Announcements</h3>
                        <div id="current-announcements"></div>
                      </div>
                      <div>
                        <h3>Events</h3>
                        <div id="current-events"></div>
                      </div>
                      <div>
                       <h3>Current Information</h3>
                        <div id="current-information"></div>
                      </div>`;
                        
                        fetchAnnouncements();
                        fetchEvents();
                        fetchInformation();
            break;
            case "notifications":
                        htmlContent = `
                        <h3>Guest Permission Response</h3>
                        <div class="card">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Guest Name</th>
                                    <th>Request</th>
                                    <th>Response Status</th>
                                </tr>
                            </thead>
                            <tbody id="guest-requests-tbody">
                                <!-- Add more permission requests dynamically -->
                            </tbody>
                        </table>
                    </div>`;
                    loadGuestRequestsStatus();
            break;  
          default:
            htmlContent = `<p>Select an option from the sidebar.</p>`;
            break;
        }

//--------------------------------------------------------------------------------------------------------
function loadGuestRequestsStatus() {
    fetch('fetchGuestRequestsHosteller.php')
        .then(response => response.json())
        .then(guestRequests => {
            const guestRequestsTbody = document.getElementById('guest-requests-tbody');
            guestRequestsTbody.innerHTML = ''; // Clear the table body
            
            guestRequests.forEach(request => {
                const row = document.createElement('tr'); // Create a new row
                
                row.innerHTML = `
                    <td>${request.guest_name}</td>
                    <td>${request.user_email}</td>
                    <td>${request.status}</td>
                `;
                
                guestRequestsTbody.appendChild(row); // Append the row to the table body
            });
        })
        .catch(error => {
            console.error('Error fetching guest requests:', error);
            const guestRequestsTbody = document.getElementById('guest-requests-tbody');
            guestRequestsTbody.innerHTML = '<tr><td colspan="3">Failed to load guest requests.</td></tr>';
        });
}

//-----------------------------------------------------------------------------------------------------------
function fetchAnnouncements() {
    fetch('fetch_announcements.php')
        .then(response => response.json())
        .then(data => {
            const announcementDiv = document.getElementById('current-announcements');
            announcementDiv.innerHTML = ''; 
            data.forEach(announcement => {
                const announcementItem = document.createElement('div');
                announcementItem.innerHTML = `
                    <p>${announcement.notice}</p>
                `;
                announcementDiv.appendChild(announcementItem);
            });
        });
}

function fetchEvents() {
    fetch('fetch_events.php')
        .then(response => response.json())
        .then(data => {
            const eventDiv = document.getElementById('current-events');
            eventDiv.innerHTML = ''; // Clear current content
            data.forEach(event => {
                const eventItem = document.createElement('div');
                eventItem.innerHTML = `
                    <p>${event.notice}</p>
                `;
                eventDiv.appendChild(eventItem);
            });
        });
}

function fetchInformation() {
    fetch('fetch_information.php')
        .then(response => response.json())
        .then(data => {
            const informationDiv = document.getElementById('current-information');
            informationDiv.innerHTML = ''; // Clear current content
            data.forEach(info => {
                const infoItem = document.createElement('div');
                infoItem.innerHTML = `
                    <p>${info.notice}</p>
                `;
                informationDiv.appendChild(infoItem);
            });
        });
}

//---------------------------------------------Function to fetch and display meals----------------------------------------------
          function fetchMeals() {
            fetch('get_meals.php')
                .then(response => response.json())
                .then(data => {
                    const mealTableBody = document.getElementById('mealTableBody');
                    mealTableBody.innerHTML = ''; // Clear existing rows

                    data.forEach(meal => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${meal.meal_type}</td>
                            <td>${meal.time_start}</td>
                            <td>${meal.time_end}</td>
                        `;
                        mealTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching meals:', error));
          }

          function orderMeal(mealType, button) {
            const row = button.closest('tr'); 
            const quantityInput = row.querySelector('.meal-quantity'); 

            const mealId = quantityInput.getAttribute('data-meal-id'); 
            const quantity = quantityInput.value; 

            if (quantity < 1) {
                alert('Please enter a valid quantity.');
                return;
            }

          
            fetch('order_meal.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    meal_id: mealId,
                    meal_type: mealType,
                    quantity: quantity,
                }),
            })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      alert('Meal ordered successfully!');
                  } else {
                      alert('Error ordering meal.');
                  }
              })
              .catch(error => console.error('Error ordering meal:', error));
          }

        content.innerHTML = htmlContent;
      }
      
//--------------------------------------------------------------------------------------------------------
function logout() {
    fetch('logout.php')
        .then(response => {
            if (response.ok) {
                return response.text();
            }
            throw new Error('Network response was not ok.');
        })
        .then(data => {
            alert(data);  
            window.location.href = 'Login_Signup.php';  
        })
        .catch(error => {
            console.error('Error logging out:', error);
            alert('An error occurred while logging out.');
        });
}
//--------------------------------------------------------------------------------------------------------

// Function to preview profile picture
      function previewProfilePicture(event) {
        const reader = new FileReader();
        reader.onload = function () {
          const output = document.getElementById("profile-picture");
          output.src = reader.result;
        };
        if (event.target.files[0]) {
          reader.readAsDataURL(event.target.files[0]);
        }
      }

//--------------------------------------------------------------------------------------------------------

      function showTab(tabId) {
        const tabs = document.querySelectorAll(".tab-content");
        tabs.forEach((tab) => {
          tab.classList.remove("active");
        });
        const buttons = document.querySelectorAll(".tab-button");
        buttons.forEach((button) => {
          button.classList.remove("active");
        });
        document.getElementById(tabId).classList.add("active");
        const activeButton = [...buttons].find(
          (button) =>
            button.textContent.trim() === tabId.replace("-", " ").toUpperCase()
        );
        if (activeButton) {
          activeButton.classList.add("active");
        }
      }

      // Handle payment form submission
      document.addEventListener("DOMContentLoaded", function () {
        document.body.addEventListener("submit", function (e) {
          if (e.target && e.target.id === "make-payment-form") {
            e.preventDefault();
            // Collect form data
            const formData = new FormData(e.target);
            const paymentData = {};
            formData.forEach((value, key) => {
              paymentData[key] = value;
            });
            console.log("Payment Data Submitted:", paymentData);
            alert("Payment submitted successfully!");
          }
        });
      });

      function calculateDuration(startDate, endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;
      }


      document.addEventListener("DOMContentLoaded", function () {
        document.body.addEventListener("submit", function (e) {
          if (e.target && e.target.id === "request-form") {
            e.preventDefault();
            const formData = new FormData(e.target);
            const requestData = {};
            formData.forEach((value, key) => {
              requestData[key] = value;
            });
            console.log("Request Data Submitted:", requestData);
            alert("Request submitted successfully!");
          }
        });
      });

      
      // Function to display review on the page
      function displayReview(reviewData) {
        const reviewsList = document.getElementById("reviews-list");
        const reviewCard = document.createElement("div");
        reviewCard.className = "review-card";
        reviewCard.innerHTML = `
        <p class="reviewer-name">Hosteller</p>
        <p class="review-text">${reviewData["review-text"]}</p>
        <p class="rating-stars">${"&#9733;".repeat(
          parseInt(reviewData["rating"])
        )}</p>
    `;
        reviewsList.appendChild(reviewCard);
      }

    </script>
  </body>
</html>
