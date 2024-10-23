<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
  </head>
  <body>
    <div class="sidebar">
      <h2>Admin Panel</h2>
      <ul>
        <li onclick="loadContent('dashboard')">Dashboard</li>
        <li onclick="loadContent('users')">User Management</li>
        <li onclick="loadContent('payment-management')">Payment Management</li>
        <li onclick="loadContent('meal')">Meal Management</li>
        <li onclick="loadContent('qr-generator')">
          Get-in Get-out QR Generator
        </li>
        <li onclick="loadContent('notifications')">Notifications</li>
        <li onclick="loadContent('manage-reviews')">Manage Reviews</li>
        <li onclick="loadContent('notice-board')">Notice Board</li>
        <li onclick="logout()">Logout</li> 
      </ul>
    </div>

    <div class="content">
      <div id="main-content">
        <h1>Welcome to Admin Dashboard</h1>
        <p>Choose an option from the sidebar to manage.</p>
      </div>
    </div>

    <script>
      function loadContent(page) {
        const content = document.getElementById("main-content");

        if (page === "dashboard") {
          content.innerHTML = `
                    <h1>Dashboard</h1>
                    <div class="card">
                        <h3>Admin Overview</h3>
                        <p>This is where you can view overall metrics of your portal.</p>
                    </div>
                `;
        } else if (page === "users") {
          content.innerHTML = `
                    <h1>User Management</h1>
                    <div class="card">
                        <h3>Manage Users</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                              <tbody id="user-table-body"></tbody>
                        </table>
                        <button class="btn" onclick="addUser()">Add User</button>
                    </div>
                `;
                fetchUsers();
        } else if (page === "payment-management") {
          content.innerHTML = `
                    <h1>Payment Management</h1>
                    <div class="card">
                        <h3>Manage Payments</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Jane Smith</td>
                                    <td>$500</td>
                                    <td>Pending</td>
                                    <td>2024-09-30</td>
                                    <td><button class="btn">Mark as Paid</button></td>
                                </tr>
                                <!-- Add more payment entries dynamically -->
                            </tbody>
                        </table>
                    </div>
                `;
        } else if (page === "meal") {
          content.innerHTML = `
                    <h1>Meal Management</h1>
                    <div class="card">
                    <h3>Add New Meal</h3>
                      <form id="mealForm" action="add_meal.php" method="POST">
                          <label for="mealType">Meal Type:</label>
                          <input type="text" id="mealType" name="mealType" required><br><br>

                          <label for="timeStart">Start Time:</label>
                          <input type="time" id="timeStart" name="timeStart" required><br><br>

                          <label for="timeEnd">End Time:</label>
                          <input type="time" id="timeEnd" name="timeEnd" required><br><br>

                          <button type="submit">Add Meal</button>
                      </form>
                    <hr>
                      <h3>Manage Meals</h3>
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>Meal Type</th>
                                  <th>Start Time</th>
                                  <th>End Time</th>
                                  <th>Actions</th>
                              </tr>
                          </thead>
                          <tbody id="mealTableBody">
                              <!-- Meals will be populated here -->
                          </tbody>
                      </table>
                    </div>
                `;
                fetchMeals();

        } else if (page === "qr-generator") {
          content.innerHTML = `
                    <h1>Get-in Get-out QR Generator</h1>
                    <div class="card">
                        <h3>QR Codes for Users</h3>
                        <p>QR codes will be generated automatically for each user.</p>
                    </div>
                `;
        } else if (page === "notifications") {
          content.innerHTML = `
                    <h1>Notifications</h1>
                    <div class="card">
                        <h3>Guest Permission Requests</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Guest Name</th>
                                    <th>Request</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="guest-requests-tbody">
                                <!-- Add more permission requests dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <div card>
                            <h3>Meal Orders</h3>
                            <form method="POST">
                                <table class="meal-table">
                                    <thead>
                                        <tr>
                                            <th>Email</th>
                                            <th>Meal Type</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orders-tbody">
                                        <!-- Data will be dynamically injected here -->
                                    </tbody>
                                </table>
                            </form>
                        </div>                
                        `;
                        fetchOrders();
                        fetchGuestRequests();
        } else if (page === "manage-reviews") {
          content.innerHTML = `
                    <h1>Manage Reviews</h1>
                    <div class="card">
                        <h3>Reviews from Hosteller Portal</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User email</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="reviews-tbody">
                    <!-- Dynamic rows will be injected here -->
                </tbody>
                        </table>
                    </div>
                `;
                fetchReviews();
        } else if (page === "notice-board") {
          content.innerHTML = `
                    <h1>Notice Board</h1>
                    <h3>Manage Announcements, Events, and Information</h3>
                    <form id="notice" action="submit_announcement.php" method="POST">
                    <div class="card">
                        <div>
                            <h4>Announcement</h4>
                            <textarea id="announcement-text" name="announcement" placeholder="Type your announcement here..."></textarea>
                            <button class="btn" onclick="submitNotice('announcement')">Submit</button>
                        </div>
                    </div> 
                    </form>
                    <form id="notice" action="submit_event.php" method="POST">
                    <div class="card">
                        <div>
                            <h4>Event</h4>
                            <textarea id="event-text" name="event" placeholder="Type your event here..."></textarea>
                            <button class="btn" onclick="submitNotice('event')">Submit</button>
                        </div>
                    </div>
                    </form>
                    <form id="notice" action="submit_information.php" method="POST">
                    <div class="card">
                        <div>
                            <h4>Information</h4>
                            <textarea id="information-text"  name="information" placeholder="Type your information here..."></textarea>
                            <button class="btn" onclick="submitNotice('information')">Submit</button>
                        </div>
                    </div>
                    </form>
                    <div>
                        <h3>Current Announcements</h3>
                        <div id="current-announcements"></div>
                    </div>
                    <div>
                        <h3>Current Events</h3>
                        <div id="current-events"></div>
                    </div>
                    <div>
                        <h3>Current Information</h3>
                        <div id="current-information"></div>
                    </div>`;
                    fetchAnnouncements();
                    fetchEvents();
                    fetchInformation();
        }
      }


//-----------------------------------------------------------------------------------------------------------------
function fetchGuestRequests() {
    const tableBody = document.getElementById('guest-requests-tbody'); 

    fetch('fetchGuestRequests.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(guestRequests => {
            console.log(guestRequests);  // Debugging output
            tableBody.innerHTML = ""; // Clear any existing content
            guestRequests.forEach(request => {  // Using 'request' for individual iteration
                tableBody.innerHTML += `
                    <tr>
                        <td>${request.user_email}</td>
                        <td>${request.guest_name}</td>
                        <td>${request.guest_date}</td>
                        <td>
                            <button class="btn" onclick="permitButtonOnClick('${request.user_email}')">Permit</button> <button class="btn" onclick="clearButton('${request.user_email}')">Clear</button> <button class="btn" onclick="deleteBtn('${request.user_email}')">Delete</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error fetching guest requests:', error);
            tableBody.innerHTML = '<tr><td colspan="4">Failed to load guest requests.</td></tr>';
        });
}

function permitButtonOnClick(user_email) {
    fetch('permitRequest.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `user_email=${encodeURIComponent(user_email)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Find the button that was clicked and disable it
            const permitButton = document.querySelector(`button[onclick="permitButtonOnClick('${user_email}')"]`);
            if (permitButton) {
                permitButton.disabled = true; // Disable the permit button
                permitButton.textContent = 'Permitted'; 
            }
        } else {
            console.error('Error permitting request:', data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function clearButton(guestEmail) {
    const tableBody = document.getElementById('guest-requests-tbody');

    // Loop through each row in the table body
    const rows = tableBody.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {
        const cells = rows[i].getElementsByTagName('td');
        
        if (cells.length > 0 && cells[0].innerText === guestEmail) {
            cells[1].innerText = ''; // Clear guest name
            cells[2].innerText = ''; // Clear guest date
            cells[3].innerText = 'Cleared'; // Optionally set status to "Cleared"
            break; 
        }
    }
}

function deleteBtn(userEmail) {
    if (confirm("Are you sure you want to delete this guest request?")) { 
        const formData = new FormData();
        formData.append('user_email', userEmail);

        fetch('deleteGuestRequest.php', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Guest request deleted successfully!');
                fetchGuestRequests(); 
            } else {
                alert('Error deleting request: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to delete guest request.');
        });
    }
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------
function fetchOrders() {
    const tableBody = document.getElementById('orders-tbody'); 

    fetch('fetchOrders.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(orders => {
            console.log(orders);  
            tableBody.innerHTML = ""; 
            orders.forEach(order => {  
                tableBody.innerHTML += `
                    <tr>
                        <td>${order.user_email}</td>
                        <td>${order.meal_type}</td>
                        <td>${order.quantity}</td>
                        <td>
                            <button class="btn" onclick="deleteOrder('${order.user_email}')">Delete</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => {
            console.error('Error fetching orders:', error);
            tableBody.innerHTML = '<tr><td colspan="4">Failed to load orders.</td></tr>';
        });
}

function deleteOrder(userEmail) {
    if (confirm('Are you sure you want to delete this order?')) {
        fetch('delete_order.php', {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_email: userEmail }), 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Order deleted:', data);
                fetchOrders(); 
            } else {
                console.error('Failed to delete order:', data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting order:', error);
        });
    }
}

//-----------------------------------------------------------------------------------------------------------------------------------------------------
function fetchReviews() {
    const tableBody = document.getElementById('reviews-tbody'); 

    fetch('manage_reviews.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(reviews => {
            console.log(reviews);  // Debugging output
            tableBody.innerHTML = ""; 
            reviews.forEach(review => {  
                tableBody.innerHTML += `
                    <tr>
                        <td>${review.user_email}</td>
                        <td>${review.review_text}</td>
                        <td>${review.rating}</td>
                        <td>
                            <button class="btn" onclick="deleteReview('${review.user_email}')">Delete</button>
                        </td>
                    </tr>
                `;
            });
        })
                .catch(error => {
                    console.error('Error fetching reviews:', error);
                    tableBody.innerHTML = '<tr><td colspan="4">Failed to load reviews.</td></tr>';
                });
        }

      function deleteReview(userEmail) {
    if (confirm('Are you sure you want to delete this review?')) {
        fetch('delete_review.php', {
            method: 'POST', 
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ user_email: userEmail }), 
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Review deleted:', data);
                fetchReviews(); 
            } else {
                console.error('Failed to delete review:', data.message);
            }
        })
        .catch(error => {
            console.error('Error deleting review:', error);
        });
    }
}  
//-------------------------------------------------------------------------------------------------------------
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
                    <button onclick="deleteNotice(${announcement.id}, 'announcement')">Delete</button>
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
            eventDiv.innerHTML = ''; 
            data.forEach(event => {
                const eventItem = document.createElement('div');
                eventItem.innerHTML = `
                    <p>${event.notice}</p>
                    <button onclick="deleteNotice(${event.id}, 'event')">Delete</button>
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
            informationDiv.innerHTML = ''; 
            data.forEach(info => {
                const infoItem = document.createElement('div');
                infoItem.innerHTML = `
                    <p>${info.notice}</p>
                    <button onclick="deleteNotice(${info.id}, 'information')">Delete</button>
                `;
                informationDiv.appendChild(infoItem);
            });
        });
}
//------------------------------------------------Delete notice js function-------------------------------------------------------------
function deleteNotice(id, type) {
    fetch('delete_notice.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${id}&type=${type}` 
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        // Refresh the list based on the type
        if (type === 'announcement') {
            fetchAnnouncements();
        } else if (type === 'event') {
            fetchEvents();
        } else if (type === 'information') {
            fetchInformation();
        }
    });
}

//------------------------------------------------------------------------------------------------------------------     
function viewUser(email) {
        window.location.href = `Hosteller_portal.php?email=${encodeURIComponent(email)}`;
      }

      function fetchUsers() {
          const tableBody = document.getElementById('user-table-body');

          fetch('fetch_users.php') // Assuming fetch_users.php returns user data in JSON format
              .then(response => {
                  if (!response.ok) {
                      throw new Error('Network response was not ok');
                  }
                  return response.json();
              })
              .then(users => {
                  console.log(users);  
                  tableBody.innerHTML = ""; 
                  users.forEach(user => {
                      tableBody.innerHTML += `
                          <tr>
                            <td>${user.id}</td>
                            <td>${user.full_name}</td>
                            <td>${user.email}</td>
                            <td>
                                <button class="btn" onclick="deleteUser(${user.id})">Delete</button>
                                <button class="btn" onclick="viewUser('${user.email}')">View</button>
                            </td>
                          </tr>
                `;
          });
        })
        .catch(error => {
            console.error('Error fetching users:', error);
            tableBody.innerHTML = '<tr><td colspan="4">Failed to load users.</td></tr>';
        });
      }

      function deleteUser(userId) {
            if (confirm("Are you sure you want to delete this user?")) {
              fetch('delete_user.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: userId })
              })
              .then(response => response.json())
              .then(result => {
                if (result.success) {
                  alert('User deleted successfully.');
                  fetchUsers(); 
                } else {
                  alert('Failed to delete user.');
                }
              })
              .catch(error => {
                console.error('Error deleting user:', error);
                alert('Error occurred while deleting user.');
              });
          }}
        
//-------------------------------------LOGOUT---------------------------------------------------------------------------
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
//------------------------------------------------------------------
      function addUser() {
        window.location.href = "add_user.php";
      }
//------------------------------------------------------------------

      function permitRequest(userName) {
        alert(`Guest permission granted for ${userName}.`);
      }

//------------------------------------------------------------------
      
    fetch('fetch_reviews.php')
        .then(response => response.json())
        .then(data => {
            const reviewsTableBody = document.getElementById('reviews-table-body');
            
            if (data.length > 0) {
                data.forEach(review => {
                    const row = document.createElement('tr');
                    
                    row.innerHTML = `
                        <td>${review.hosteller_name}</td>
                        <td>${review.review_text}</td>
                        <td>${review.rating}</td>
                        <td><button class="delete-btn" data-review="${review.review_text}">Delete</button></td>
                    `;
                    
                    reviewsTableBody.appendChild(row);
                });
            } else {
                reviewsTableBody.innerHTML = '<tr><td colspan="4">No reviews found.</td></tr>';
            }

            
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const reviewText = this.getAttribute('data-review');
                    deleteReview(reviewText);
                });
            });
        })
        .catch(error => {
            console.error('Error fetching reviews:', error);
        });

//------------------------------------------------------------------

 

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
                    <td>
                        <button onclick="deleteMeal('${meal.meal_type}')">Delete</button>
                    </td>
                `;
                mealTableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching meals:', error));
}

function deleteMeal(mealType) {
    if (confirm('Are you sure you want to delete this meal?')) {
        fetch('delete_meal.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `meal_type=${encodeURIComponent(mealType)}`,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Meal deleted successfully.');
                fetchMeals(); 
            } else {
                alert('Error deleting meal: ' + data.message);
            }
        })
        .catch(error => console.error('Error deleting meal:', error));
    }
}

            function generateQRCode(elementId, text) {
              const qrCode = new QRCode(document.getElementById(elementId), {
                text: text,
                width: 128,
                height: 128,
              });
            }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
  </body>
</html>
