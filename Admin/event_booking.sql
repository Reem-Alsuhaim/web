-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29 نوفمبر 2025 الساعة 21:36
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_booking`
--

-- --------------------------------------------------------

--
-- بنية الجدول `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `booking_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `available` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `events`
--

INSERT INTO `events` (`id`, `name`, `image`, `event_date`, `event_time`, `location`, `description`, `available`, `price`) VALUES
(9, 'Into the Deep', 'Into_the_Deep.jpg', '2025-12-06', '09:00:00', 'Discovery Springs', 'Ride type: Family ride\n\nThrill level: Mild thrill\n\nAbout the ride :\nJourney into mysterious caves on this interactive and dark ride experience, featuring dimmed lighting and interactive elements.\n\nRide features :\n•Dark ride\n•Interactive\n\nHeight requirement:\n100–200 cm\n\nAdult companion:\nRequired if below 130 cm', 150, 100.00),
(10, 'Arabian Carousel', 'Arabian_Carousel.jpg', '2025-12-05', '19:00:00', 'Grand Exposition', 'Ride type: Family ride\n\nThrill level: Low thrill\n\nAbout the ride:\nAs the lights dim and the music begins, guests astride prancing horses and camels twirl to the sounds of an Arabian melody.\n\nRide features:\n•Flat ride\n\nHeight requirement:\nMin 90 cm\n\nAdult companion:\nRequired if below 130 cm', 200, 75.00),
(11, 'Iron Rattler', 'Iron_Rattler.jpg', '2025-12-04', '12:00:00', 'Steam Town', 'Teeter over the edge and peer into the depths on Iron Rattler, a fast and wild tilt coaster at the end of Gear Street. The Iron Rattler Mining Company promises an exhilarating adventure as they board the coaster and follow the exciting path of many prospectors before them.\n\n\nRide Type: Thrill\nThrill Level: Extreme\n\nRide Features:\n• Record-breaking\n• Roller coaster\n\nHeight Requirement: 120–205 cm\nAdult Companion: Required for riders below 130 cm', 250, 50.00),
(12, 'Spitfire', 'Spitfire.jpg', '2025-12-03', '10:00:00', 'Valley of Fortune', 'Ride type: Thrill\n\nThrill level: Extreme\n\nAbout the ride:\nSpitfire is a record-shredding triple-launch roller coaster! Stunt pilots are welcomed, ready to embark on a \"thrill-seekers\" dream. They must skillfully pilot their plane for the opportunity to win the coveted Golden Falcon Statue.\nThe victory comes with a great challenge and presents an even greater thrill as pilots are faced with the task of completing the most exhilarating plane stunt of all.\n\nRide features:\n•Record breaking\n•Roller coaster\n\nHeight requirement:\n130–196 cm', 100, 40.00),
(13, 'Sirocco Tower', 'Sirocco_Tower.jpg', '2025-12-02', '06:00:00', 'City of Thrills', 'Ride type: Thrill\n\nThrill level: Extreme\n\nAbout the ride:\nExperience the ultimate thrill with a towering ride that launches sky-high, then plummets in an exhilarating freefall. Sirocco Tower powers the City of Thrills by harnessing the Sirocco winds that have graced the land for centuries.\n\nRide features:\n•Record breaking\n•Drop tower\n\nHeight requirement:\n130–205 cm', 500, 25.00),
(14, 'Gyrospin', 'Gyrospin.jpg', '2025-12-01', '20:00:00', 'Grand Exposition', 'Ride type: Thrill\n\nThrill level: Extreme\n\nAbout the ride:\nA thrilling ride that soars to great heights and spinning G-forces. A true credit to Mr. Tesla’s futurist vision.\n\nRide features\n•Record breaking\n•Flat ride\n\nHeight requirement:\n135–200 cm', 120, 60.00),
(15, 'Aquatopia', 'Aquatopia.png', '2025-11-01', '08:00:00', 'Discovery Springs', 'Ride type: Kids ride\r\n\r\nThrill level: Low thrill\r\n\r\nAbout the attraction\r\nDive into a world of watery fun with this aquatic playground, Aquatopia. This is the perfect spot for young adventurers and their families to splash, play, and explore together.\r\n\r\n:Ride features\r\nPlayground•\r\n\r\n:Height requirement\r\nN/A\r\n\r\n:Adult companion\r\nRequired if below 130 cm', 200, 70.00);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
