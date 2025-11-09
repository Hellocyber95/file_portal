-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2025 at 06:30 PM
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
-- Database: `file_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(1, 2, 13, 1),
(2, 2, 2, 1),
(4, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `uploaded_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `user_id`, `filename`, `filepath`, `content`, `uploaded_at`) VALUES
(1, 1, 'sample1.jpg', '', '', '0000-00-00 00:00:00'),
(2, 1, 'sample2.jpg', '', '', '0000-00-00 00:00:00'),
(3, 1, 'sample3.jpg', '', '', '0000-00-00 00:00:00'),
(4, 1, 'sample4.jpg', '', '', '0000-00-00 00:00:00'),
(5, 1, 'sample5.jpg', '', '', '0000-00-00 00:00:00'),
(6, 1, 'sample6.jpg', '', '', '0000-00-00 00:00:00'),
(7, 1, 'sample7.jpg', '', '', '0000-00-00 00:00:00'),
(8, 1, 'sample8.jpg', '', '', '0000-00-00 00:00:00'),
(9, 1, 'sample9.jpg', '', '', '0000-00-00 00:00:00'),
(10, 1, 'sample10.jpg', '', '', '0000-00-00 00:00:00'),
(11, 1, 'file1.txt', '', '', '0000-00-00 00:00:00'),
(12, 1, 'file2.txt', '', '', '0000-00-00 00:00:00'),
(13, 1, 'file3.txt', '', '', '0000-00-00 00:00:00'),
(14, 1, 'file4.txt', '', '', '0000-00-00 00:00:00'),
(15, 1, 'file5.txt', '', '', '0000-00-00 00:00:00'),
(16, 1, 'file6.txt', '', '', '0000-00-00 00:00:00'),
(17, 1, 'file7.txt', '', '', '0000-00-00 00:00:00'),
(18, 1, 'file8.txt', '', '', '0000-00-00 00:00:00'),
(19, 1, 'file9.txt', '', '', '0000-00-00 00:00:00'),
(20, 1, 'file10.txt', '', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`) VALUES
(1, 'Handbag', 'Stylish leather handbag for women', 1200.00, 'handbag.jpg'),
(2, 'Wrist Watch', 'Elegant analog wrist watch', 999.00, 'watch.jpg'),
(3, 'Sneakers', 'Trendy sneakers for men', 1500.00, 'sneakers.jpg'),
(4, 'T-shirt', 'Cotton casual T-shirt', 499.00, 'tshirt.jpg'),
(5, 'Jeans', 'Denim blue jeans', 899.00, 'jeans.jpg'),
(6, 'Saree', 'Traditional silk saree', 1999.00, 'saree.jpg'),
(7, 'Shoes', 'Formal office shoes', 1799.00, 'shoes.jpg'),
(8, 'Earphones', 'Wireless Bluetooth earphones', 899.00, 'earphones.jpg'),
(9, 'Mobile Cover', 'Shockproof mobile case', 299.00, 'cover.jpg'),
(10, 'Perfume', 'Long lasting fragrance perfume', 799.00, 'perfume.jpg'),
(11, 'Sunglasses', 'UV protected stylish sunglasses', 699.00, 'sunglasses.jpg'),
(12, 'Makeup Kit', 'Cosmetic kit for women', 1299.00, 'makeup.jpg'),
(13, 'Smart Watch', 'Touch screen smart watch', 2499.00, 'smartwatch.jpg'),
(14, 'Bag Pack', 'Waterproof travel backpack', 999.00, 'bagpack.jpg'),
(15, 'Dress', 'Western party wear dress', 1599.00, 'dress.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `is_logged_in` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `is_logged_in`) VALUES
(1, 'admin', 'admin123', 'user', 1),
(2, 'abhi', '1234', 'user', 1),
(3, 'Hunter', 'asdfgh', 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
