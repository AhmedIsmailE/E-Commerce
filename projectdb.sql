-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2025 at 07:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'Laptops'),
(2, 'Phones'),
(3, 'Tablets');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `createdAt` datetime DEFAULT current_timestamp(),
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `price`, `createdAt`, `status`) VALUES
(6, 3, 15, 1, 53400.00, '2025-07-26 02:33:53', 'processing'),
(7, 3, 14, 1, 39500.00, '2025-07-26 02:33:53', 'processing'),
(8, 3, 15, 1, 53400.00, '2025-07-26 02:39:00', 'processing'),
(9, 3, 14, 1, 39500.00, '2025-07-26 02:39:00', 'processing');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_desc` text DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `product_quantity` int(11) DEFAULT 0,
  `product_price` decimal(10,2) NOT NULL,
  `percentage_discount` int(3) DEFAULT 0,
  `online_date` datetime DEFAULT current_timestamp(),
  `product_img` varchar(255) DEFAULT NULL,
  `price_after_sale` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_desc`, `category_id`, `product_quantity`, `product_price`, `percentage_discount`, `online_date`, `product_img`, `price_after_sale`) VALUES
(6, 'Apple iPhone 16 Pro Max ', '(256 GB) - Desert Titanium with Face ID | Tax Paid | 2 Years Official Warranty Brand: Apple', 2, 100, 93200.00, 7, '2025-07-22 00:00:00', '1753266417_61rriyfRKwL._AC_UL480_FMwebp_QL65_.webp', 86676.00),
(7, 'Apple iPhone 13', '(128 GB) - Starlight with Face ID | Tax Paid | 2 Years Official Warranty', 2, 0, 34222.00, 14, '2025-07-23 00:00:00', '1753266728_71GLMJ7TQiL._AC_UL480_FMwebp_QL65_.webp', 29430.92),
(8, 'Apple iPhone 13 ', '128 GB - Midnight with Face ID | Tax Paid | 2 Years Official Warranty', 2, 10, 30890.00, 3, '2025-07-23 00:00:00', '1753266048_61VuVU94RnL._AC_UL480_FMwebp_QL65_.webp', 29963.30),
(9, 'Apple iPhone 16', '(128 GB) - Ultramarine with Face ID | Tax Paid | 2 Years Official Warranty', 2, 30, 58500.00, 0, '2025-07-23 00:00:00', '1753266863_713SsA7gftL._AC_UL480_FMwebp_QL65_.webp', 58500.00),
(10, 'Apple iPhone 16 Plus', '(128 GB) - Green with Face ID, (2 years Official Warranty)', 2, 5, 66999.00, 0, '2025-07-23 00:00:00', '1753267021_712SeOsnKUL._AC_SX679_.jpg', 66999.00),
(11, 'Apple iPhone 16 Pro', '(128 GB) - Natural Titanium with Face ID | Tax Paid | 2 Years Official Warranty', 2, 7, 77999.00, 0, '2025-07-23 00:00:00', '1753267207_61WjAY5IoxL._AC_SX679_.jpg', 77999.00),
(12, 'Apple 2025 MacBook Air 13-inch Laptop', 'Built for Apple Intelligence, 13.6-inch Liquid Retina Display, 16GB Unified Memory, 256GB SSD Storage, 12MP Center Stage Camera, Touch ID; Midnight', 1, 6, 55555.00, 0, '2025-07-23 00:00:00', '1753267373_71cWZUr9SVL._AC_SX679_.jpg', 55555.00),
(13, 'Apple 2024 MacBook Air ', '(15-inch, Apple M3 chip with 8‑core CPU and 10‑core GPU, 8GB Unified Memory, 256GB) - Silver', 1, 3, 66800.00, 0, '2025-07-23 00:00:00', '1753267501_71aUQCKUwTL._AC_SX679_.jpg', 66800.00),
(14, 'Apple Macbook Air 2020 Model', '(13-Inch, Apple M1 chip with 8-core CPU and 7-core GPU, 8GB, 256GB, MGN63), Eng-KB, Space Gray', 1, 4, 39500.00, 0, '2025-07-23 00:00:00', '1753267782_71jG+e7roXL._AC_SX679_.jpg', 39500.00),
(15, ' Apple 2022 MacBook Air laptop', '13.6-inch Liquid Retina display, 16GB RAM, 256GB SSD storage, backlit keyboard, 1080p FaceTime HD camera. Works with iPhone and iPad; Starlight, English', 1, 6, 53400.00, 0, '2025-07-23 00:00:00', '1753267894_41QQLc1ROkL._AC_.jpg', 53400.00),
(16, 'Apple 13-Inch iPad Pro', 'M4 Chip 13-Inch 256GB Tablet with Standard Glass, Space Black', 3, 4, 66350.00, 0, '2025-07-23 00:00:00', '1753268166_718LMucOztL._AC_SX679_.jpg', 66350.00),
(17, 'Apple iPad 11-inch', ' A16 chip, 11-inch Model, Liquid Retina Display, 128GB, Wi-Fi 6, 12MP Front/12MP Back Camera, Touch ID, All-Day Battery Life — Silver', 3, 3, 20800.00, 0, '2025-07-23 00:00:00', '1753268318_31V5gP1XosL._AC_.jpg', 20800.00),
(18, 'Apple iPad Pro 11-Inch', 'Built for Apple Intelligence, Ultra Retina XDR Display, 256GB, 12MP Front/Back Camera, LiDAR Scanner, Wi-Fi 6E, Face ID, All-Day Battery Life — Silver', 3, 5, 58000.00, 0, '2025-07-23 00:00:00', '1753268403_61eoFTuljuL._AC_SX679_.jpg', 58000.00),
(19, 'Apple iPad Air 11-inch', 'Liquid Retina display, 256GB, Landscape 12MP Front Camera/12MP Back Camera, Wi-Fi 6E, Touch ID, All-Day Battery Life - Blue', 3, 10, 35950.00, 2, '2025-07-23 00:00:00', '1753268586_71TIfKvgG3L._AC_SX679_.jpg', 35231.00),
(20, 'Apple iPhone 13', '(256 GB) - Desert Titanium with Face ID | Tax Paid | 2 Years Official Warranty Brand: Apple', 2, 5, 29255.00, 5, '2025-07-22 00:00:00', '1753280266_71GLMJ7TQiL._AC_UL480_FMwebp_QL65_.webp', 27792.25);

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `set_price_after_sale` BEFORE INSERT ON `products` FOR EACH ROW BEGIN
    SET NEW.price_after_sale = NEW.product_price - (NEW.product_price * NEW.percentage_discount / 100);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) DEFAULT NULL,
  `lastName` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `role`) VALUES
(1, 'Youssef', 'Ayman', 'youssef@gmail.com', '123456', 'admin'),
(2, 'Ahmed', 'Ismail', 'ahmed@gmail.com', '4567890', 'admin'),
(3, 'Mostafa', 'Elgendy', 'mostafa@gmail.com', '123456', 'customer'),
(4, 'Mohamed', 'Hany', 'mohamed@gmail.com', '12345632', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
