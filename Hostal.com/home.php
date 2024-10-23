<?php 
session_start();
if (!isset($_SESSION['email'])) {
    echo "User is not logged in.";
    exit();
}

$email = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hostel.com</title>
    <link rel="stylesheet" href="home.css">
    <script>
      function toggleMenu() {
        document.querySelector(".navbar").classList.toggle("active");
      }

      function toggleHamburgerMenu() {
        const menu = document.querySelector(".hamburger-menu");
        menu.style.display = menu.style.display === "block" ? "none" : "block";
        menu.style.opacity = menu.style.display === "block" ? "1" : "0";
        menu.style.transform =
          menu.style.display === "block"
            ? "translateY(0)"
            : "translateY(-20px)";
      }

      // Add scroll event listener for content reveal
      document.addEventListener("scroll", () => {
        document.querySelectorAll(".reveal").forEach((element) => {
          const rect = element.getBoundingClientRect();
          if (rect.top <= window.innerHeight && rect.bottom >= 0) {
            element.classList.add("in-view");
          }
        });
      });
    </script>
  </head>

  <body>
    <header class="navbar">
      <div class="brand">Hostel.com</div>
      <ul class="menu">
        <li><a href="#header-section">Home</a></li>
        <li><a href="reservation.php">Reservation</a></li>
        <li><a href="#reviews-section">Ratings and Reviews</a></li>
        <li><a href="#about-section">About Us</a></li>
      </ul>
      <!-- Hamburger and User Icon Buttons -->
      <div>
        <span class="hamburger" onclick="toggleHamburgerMenu()">&#9776;</span>
        <span class="user-icon">&#128100;</span>
      </div>
      <!-- Hamburger Menu Dropdown -->
      <div class="hamburger-menu">
        <a href="Login_Signup.php">Logout</a>
        <a href="Hosteller_portal.php">Portal</a>
      </div>
    </header>

    <!-- Sliding Text Example -->
    <div class="slider">
      <div class="slider-text">
        Welcome to Hostel.com - Your Ideal Stay Destination
      </div>
    </div>

    <header class="section__container header__container" id="header-section">
      <div class="header__image__container">
        <div class="header__content">
          <h1>Enjoy Your Dream Hostel</h1>
          <p>
            Book your rooms, feels like your home and stay packages at lowest
            price.
          </p>
        </div>
      </div>
    </header>

    <!-- First Row: Image on Left, Description on Right -->
    <div class="parallax">
      <div class="container">
        <div class="image-container">
          <img src="C:\wamp64\www\Hostal.com\Hostal.com\images\single room\hos1.webp" />
        </div>
        <div class="description-container">
          <h2>Title for First Section</h2>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat.
          </p>
        </div>
      </div>

      <!-- Second Row: Description on Left, Image on Right -->
      <div class="container">
        <div class="description-container">
          <h2>Title for Second Section</h2>
          <p>
            Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
            cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
          </p>
        </div>
        <div class="image-container">
          <img src="https://via.placeholder.com/400" alt="Sample Image" />
        </div>
      </div>

      <!-- third Row: Image on Left, Description on Right -->

      <div class="container">
        <div class="image-container">
          <img src="https://via.placeholder.com/400" alt="Sample Image" />
        </div>
        <div class="description-container">
          <h2>Title for First Section</h2>
          <p>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat.
          </p>
        </div>
      </div>

      <!-- forth raw: Description on Left, Image on Right -->
      <div class="container">
        <div class="description-container">
          <h2>Title for Second Section</h2>
          <p>
            Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
            cupidatat non proident, sunt in culpa qui officia deserunt mollit
            anim id est laborum.
          </p>
        </div>
        <div class="image-container">
          <img src="https://via.placeholder.com/400" alt="Sample Image" />
        </div>
      </div>

      <div class="review-section" id="reviews-section">

      <?php include 'fetch_reviews.php'; ?> 

      </div>
    </div>

    <section class="about-section reveal" id="about-section">
      <h2>About Us</h2>
      <p>
        Welcome to Hostel.com, your ideal stay destination. Our hostel offers a
        comfortable and friendly environment where you can relax and enjoy your
        stay. We are known for our excellent service, cleanliness, and modern
        facilities. Whether you are traveling for leisure or business, our rooms
        are designed to meet your needs with utmost comfort and convenience.
        Experience the best of hospitality at Hostel.com.
      </p>
    </section>

    <footer class="footer">
      <div class="section__container footer__container">
        <div class="footer__col">
          <h3>Hostel.com</h3>
          <p>
            Hostel.com is a premier platform for finding and booking hostels
            around the world, offering a seamless and convenient experience for
            travelers.
          </p>
          <p>
            With an intuitive interface and a diverse range of hostel options,
            Hostel.com is dedicated to providing a stress-free way for travelers
            to discover their ideal accommodation.
          </p>
        </div>
        <div class="footer__col">
          <h4>hostel.com</h4>
          <p>About Us</p>
          <p>Our Team</p>
          <p>Contact Us</p>
        </div>
        <div class="footer__col">
          <h4>Legal</h4>
          <p>FAQs</p>
          <p>Terms & Conditions</p>
          <p>Privacy Policy</p>
        </div>
        <div class="footer__col">
          <h4>Resources</h4>
          <p>Social Media</p>
          <p>Help Center</p>
          <p>Partnerships</p>
        </div>
      </div>
      <div class="footer__bar">
        Copyright © 2024 ICBT HD Student Final Project . All rights reserved.
      </div>
    </footer>
  </body>
</html>
