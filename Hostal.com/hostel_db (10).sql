-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 12, 2024 at 06:51 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notice` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `notice`, `created_at`) VALUES
(6, '📢 Exciting News from Hostal.com! 🏡\r\n\r\nWe are thrilled to announce the official opening of Hostal.com, your new home away from home! Whether you\'re a student, traveler, or professional, we\'ve got a place for you! 🌍✨\r\n\r\nWhy Choose Hostal.com?\r\n\r\n🛏️ Comfortable, clean, and affordable rooms.\r\n🌐 Free high-speed Wi-Fi.\r\n🍽️ In-house dining options and kitchen facilities.\r\n🧳 Secure luggage storage and 24/7 security.\r\n🧼 Laundry services for hassle-free living.\r\n', '2024-10-06 19:11:53');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `room_number` varchar(10) DEFAULT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `cardholder_name` varchar(100) DEFAULT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `expiry_date` varchar(5) DEFAULT NULL,
  `cvv` varchar(3) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `booking_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) DEFAULT 'available',
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `room_number`, `room_type`, `duration`, `cardholder_name`, `card_number`, `expiry_date`, `cvv`, `amount`, `booking_date`, `status`, `user_id`) VALUES
(43, '1', 'Single Room', 3, 'Fad', '1234567890234233', '04/25', '911', 5000.00, '2024-10-07 22:26:14', 'booked', NULL),
(44, '2', 'Single Room', 3, 'Fad', '1234567890234233', '04/25', '911', 5000.00, '2024-10-08 08:09:29', 'booked', NULL),
(45, '3', 'Single Room', 3, 'Fad', '1234567890234233', '04/25', '911', 5000.00, '2024-10-08 08:09:52', 'booked', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notice` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `notice`, `created_at`) VALUES
(3, '📢 Upcoming Event at Hostel.com! 🏡🎉\r\n\r\nDear Residents and Guests,\r\n\r\nWe are excited to announce our next Holy Event happening at Hostel.com! 🎊 Don’t miss out on a fun-filled day packed with exciting activities, great food, and an opportunity to meet your fellow hostel mates!\r\n\r\nEvent Details:\r\n\r\n📅 Date: 2024.10.09\r\n🕒 Time: 4.00PM\r\n📍 Location: Wellawatta\r\nWhat to Expect:\r\n\r\n🎶 Live Music & Entertainment\r\n🍕 Free Food & Beverages\r\n🏆 Fun Games & Competitions (With exciting prizes to be won!)\r\n🎨 Creative Workshops & Activities\r\n🤝 Meet & Greet with new residents\r\nWhether you’re new to the hostel or a long-term resident, this is a great opportunity to relax, socialize, and make new friends!', '2024-10-06 19:14:23');

-- --------------------------------------------------------

--
-- Table structure for table `guest_requests`
--

DROP TABLE IF EXISTS `guest_requests`;
CREATE TABLE IF NOT EXISTS `guest_requests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) NOT NULL,
  `guest_name` varchar(255) NOT NULL,
  `guest_date` date NOT NULL,
  `status` enum('pending','permitted') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guest_requests`
--

INSERT INTO `guest_requests` (`id`, `user_email`, `guest_name`, `guest_date`, `status`) VALUES
(14, 'fad@gmail.com', 'Mical Anjelo', '2024-10-24', 'permitted'),
(13, 'gav@gmail.com', 'Liyanado Dawinchi', '2024-10-28', 'pending'),
(15, 'fadhilak500@gmail.com', 'Gavindu', '1111-11-11', 'permitted');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
CREATE TABLE IF NOT EXISTS `information` (
  `id` int NOT NULL AUTO_INCREMENT,
  `notice` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`id`, `notice`, `created_at`) VALUES
(5, 'Hostel Information: 🏢 About Us: At Hostel.com, we provide a cozy, safe, and affordable place for travelers, students, and professionals. Our mission is to create a friendly environment where guests can connect and enjoy their stay. 🌟 Facilities: Comfortable Dormitories: Spacious and well-ventilated rooms with comfortable beds. Private Rooms: For those seeking a bit more privacy. Common Areas: Relax, socialize, or study in our communal lounge and dining area. Free Wi-Fi: Stay connected with complimentary high-speed internet throughout the hostel. Kitchen Access: Fully equipped kitchen for self-catering. Laundry Services: On-site laundry facilities for your convenience. 🗓️ Check-In/Check-Out: Check-In Time: 6.00AM Check-Out Time: 6.00PM 🚪 House Rules: Respect the privacy and comfort of fellow guests. Keep noise levels to a minimum during quiet hours. No outside guests allowed in private rooms after [Time]. Smoking is not permitted in indoor areas. Dispose of trash properly and keep common areas clean. 📞 Contact Us: For inquiries or assistance, please contact our front desk at [Phone Number] or email us at [Email Address]. Our team is here to help you 24/7! 🌍 Connect with Us: Follow us on [Social Media Links] for updates, events, and special promotions!', '2024-10-07 03:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `meals`
--

DROP TABLE IF EXISTS `meals`;
CREATE TABLE IF NOT EXISTS `meals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `meal_type` varchar(100) NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `meals`
--

INSERT INTO `meals` (`id`, `meal_type`, `time_start`, `time_end`) VALUES
(5, 'Breakfast', '08:00:00', '11:00:00'),
(6, 'Lunch', '12:00:00', '14:00:00'),
(9, 'Dinner', '19:00:00', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `meal_type` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_email`, `meal_type`, `quantity`, `order_date`) VALUES
(5, 'fad@gmail.com', 'Breakfast', 1, '2024-10-07 07:16:23'),
(12, 'fadhilak500@gmail.com', 'Breakfast', 2, '2024-10-11 08:36:55');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `review_text` text NOT NULL,
  `rating` int NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hosteller_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `review_text`, `rating`, `user_email`, `created_at`, `hosteller_name`) VALUES
(18, 'This hostel was everything I could have hoped for—clean, cozy, and in a perfect location! The staff was incredibly friendly and helpful, making my stay even more enjoyable. Highly recommend for budget travelers looking for comfort and convenience!', 4, 'gav@gmail.com', '2024-10-07 19:18:02', NULL),
(19, 'Amazing experience! The hostel was clean, comfortable, and located in a great area. The staff were super friendly and helpful, making sure everything was perfect during my stay. Highly recommend!', 5, 'fad@gmail.com', '2024-10-07 19:19:16', NULL),
(20, 'bla bla bla', 4, 'fadhilak500@gmail.com', '2024-10-11 08:37:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  `NIC` varchar(100) NOT NULL,
  `contact_num` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `terms` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` enum('inside','outside') NOT NULL DEFAULT 'outside',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `address`, `NIC`, `contact_num`, `dob`, `email`, `password`, `terms`, `image`, `status`) VALUES
(87, 'Fadhila', 'CMB', '200085101552', '0776746496', '2002-12-16', 'fadhilak500@gmail.com', '$2y$10$4nCefFzXwjOT6X5tS3wPC..QLsphJPxkyKyEioanhVeyD2qtfPRsa', 0, 'uploads/123.jpg', 'outside');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
