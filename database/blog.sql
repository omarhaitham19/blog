-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2024 at 04:51 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `body` text NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `image`, `body`, `user_id`, `created_at`) VALUES
(15, 'Post one', '65ca4a7d870e9_1.png', 'People who live in glass houses should not throw stones. That&#039;s the advice from experts who say that criticizing others can come back to haunt you. It&#039;s essential to practice what you preach and lead by example.', 1, '2024-02-12 18:42:37'),
(16, 'Post two', '65ca4a97cdf44_2.png', 'The early bird catches the worm, or so they say. Waking up early has been linked to increased productivity and better mental health. So, why not give it a try and see if it makes a positive difference in your life?', 1, '2024-02-12 18:43:03'),
(18, 'Post three', '65ca4ad656a1c_product_02.jpg', 'Life is like a rollercoaster with its ups and downs. Embracing the challenges and learning from failures is crucial for personal growth. Remember, every setback is a setup for a comeback.', 1, '2024-02-12 18:44:06'),
(20, 'Post four', '65cbfb031316d_product_04.jpg', 'A journey of a thousand miles begins with a single step. Setting small, achievable goals is the key to reaching larger milestones. Don&#039;t be afraid to take that first step toward your dreams.', 14, '2024-02-14 01:28:03'),
(21, 'Post five', '65cbfc5bc4036_product_06.jpg', 'Creativity is intelligence having fun. Don&#039;t be afraid to let your imagination run wild and explore new ideas. Innovation often comes from thinking outside the box and daring to be different.', 15, '2024-02-14 01:33:47'),
(22, 'Post six', '65cc099b720a1_slide_01.jpg', 'Laughter is the best medicine. In a world full of stress and challenges, finding moments of joy is essential. Surround yourself with positivity and don&#039;t forget to share a good laugh with those around you.', 1, '2024-02-14 02:29:45'),
(23, 'Post seven', '65ce6af597e5f_contact-heading.jpg', 'Exploring new horizons can be a transformative experience. Whether it&#039;s traveling to unfamiliar places or trying out a new hobby, stepping out of your comfort zone opens the door to personal growth and discovery. Embrace the unknown and savor the excitement of new beginnings.\r\nRemember, life is a book, and those who do not travel read only a page. So, pack your bags, embark on new adventures, and let the chapters of your life unfold with each unique journey.', 1, '2024-02-15 21:50:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `created_at`) VALUES
(1, 'omar', 'omar@gmail.com', '$2y$10$7/h6MeBG9A0OtTfsZ0V/iOJ6k5F3B6ruCgJ7/Kngd0ddKZ3U9dI5K', '01002531616', '2024-02-13 01:13:00'),
(14, 'mazen', 'mazen@gmail.com', '$2y$10$oL8oIFnJWS2Ssj6uCiLSxOs3.bM3n.stghxvDHA7HA0lTM0F5XG5e', '01002531615', '2024-02-14 01:27:03'),
(15, 'ahmed husam', 'ahmed@gmail.com', '$2y$10$6uZTsD1PQP77DKOpIKoabOVY8.XzhZxOmtayA5YBrCFeAE9IsixYu', '01007531616', '2024-02-14 01:32:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
