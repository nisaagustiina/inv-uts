-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2026 at 06:48 AM
-- Server version: 8.0.33
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(5, 'Books'),
(3, 'Clothing'),
(1, 'Electronics'),
(4, 'Food'),
(2, 'Furniture'),
(6, 'Sports');

-- --------------------------------------------------------

--
-- Table structure for table `goods`
--

CREATE TABLE `goods` (
  `id` int NOT NULL,
  `name` varchar(199) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `category_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `goods`
--

INSERT INTO `goods` (`id`, `name`, `description`, `price`, `stock`, `unit`, `category_id`, `created_at`) VALUES
(1, 'Laptop ASUS', 'High performance laptop', 7000000.00, 10, 'pcs', 1, '2026-06-08 13:16:53'),
(2, 'Gaming Mouse', 'RGB gaming mouse', 250000.00, 25, 'pcs', 1, '2026-06-08 13:16:53'),
(3, 'Mechanical Keyboard', 'Blue switch keyboard', 650000.00, 15, 'pcs', 1, '2026-06-08 13:16:53'),
(4, 'Office Chair', 'Ergonomic office chair', 850000.00, 8, 'pcs', 2, '2026-06-08 13:16:53'),
(5, 'Wooden Desk', 'Minimalist work desk', 1500000.00, 5, 'pcs', 2, '2026-06-08 13:16:53'),
(6, 'Bookshelf', '5-tier wooden bookshelf', 950000.00, 7, 'pcs', 2, '2026-06-08 13:16:53'),
(7, 'Cotton T-Shirt', 'Comfortable cotton shirt', 75000.00, 100, 'pcs', 3, '2026-06-08 13:16:53'),
(8, 'Denim Jeans', 'Slim fit jeans', 180000.00, 50, 'pcs', 3, '2026-06-08 13:16:53'),
(9, 'Hoodie', 'Warm casual hoodie', 220000.00, 40, 'pcs', 3, '2026-06-08 13:16:53'),
(10, 'Instant Noodles', 'Chicken flavor noodles', 3500.00, 200, 'pack', 4, '2026-06-08 13:16:53'),
(11, 'Mineral Water', '600ml bottled water', 4000.00, 150, 'bottle', 4, '2026-06-08 13:16:53'),
(12, 'Chocolate Bar', 'Milk chocolate snack', 12000.00, 80, 'pcs', 4, '2026-06-08 13:16:53'),
(13, 'Programming Book', 'Learn SQL and Databases', 120000.00, 20, 'pcs', 5, '2026-06-08 13:16:53'),
(17, 'Mouse Gaming', 'mouse untuk gaming', 2000000.00, 10, 'pcs', 1, '2026-06-10 15:38:09'),
(18, 'Harry Potter', 'buku harry potter', 187000.00, 8, 'pcs', 5, '2026-06-11 02:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(199) NOT NULL,
  `username` varchar(199) NOT NULL,
  `email` varchar(199) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin', 'admin@gmail.com', '$2y$10$iumM/tIHReGwkl66YSP7j.c0hEvyRjGdKAlsesZEb6TSkJBV.HqCG', 'admin', '2026-06-08 13:16:53'),
(4, 'Raska', 'raska', 'raska@mail.com', '$2y$12$5dJzyo55N5t2Pxri8Amft.A64SIS3hDFDPkKX1EmDowoXG2bp61HO', 'user', '2026-06-10 15:40:20'),
(5, 'Nisa', 'nisa', 'nisa@gmail.com', '$2y$12$6hIAd2DJekWZHmNvZNSqkO1ZpgDa9/Uo1XnCyz9s7N87jOwJ9WpQa', 'user', '2026-06-11 03:00:42'),
(8, 'Yuni', 'yuni', 'yuni12@gmail.com', '$2y$12$AzlqRTJKoSWNYKHV1o4Dp.8QYBRRDZEGpxL.b/J5RLcYuajKiCOvW', 'user', '2026-06-11 06:47:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

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
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `goods`
--
ALTER TABLE `goods`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `goods`
--
ALTER TABLE `goods`
  ADD CONSTRAINT `goods_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
