-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2023 at 05:57 AM
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
-- Database: `food_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'ChuaKimYao', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2'),
(3, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `rating` int(10) NOT NULL,
  `details` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `rating`, `details`, `size`, `type`, `quantity`, `image`) VALUES
(74, 13, 29, 'Beef Burger', 12, 4, 'A very classic Beef BURGER!!!', 'normal', 'Non Veg', 1, 'burger-1.png'),
(75, 13, 27, 'Chicken Burger', 10, 5, 'A very classic Chicken BURGER!!!', 'normal', 'Non Veg', 1, 'burger-2.png'),
(76, 13, 28, 'Limau Ice', 4, 4, 'Limau and Ice ~', 'normal', 'Cold', 1, 'drink-3.png');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(3, 8, 'Chua Kim Yao', 'kimyao2003@gmail.com', '1234567890', 'HI'),
(4, 8, 'Chua Kim Yao', 'kimyao2003@gmail.com', '1234586465', 'Hello');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `order_status`) VALUES
(26, 8, 'Chua Kim Yao', '1234567890', 'kimyao2003@gmail.com', 'credit card', '9,Jalan Setia Nusantara U13/19f, Setia Eco Park, 40170, Shah Alam, Malaysia', 'Limau Ice (4 x 1) - ', 4, '2023-10-28 19:59:59', 'completed'),
(27, 8, 'Chua Kim Yao', '1234567890', 'kimyao2003@gmail.com', 'credit card', '9,Jalan Setia Nusantara U13/19f, Setia Eco Park, 40170, Shah Alam, Malaysia', 'Chicken Burger (10 x 2) - ', 20, '2023-10-30 11:09:20', 'completed'),
(28, 8, 'Chua Kim Yao', '1234567890', 'kimyao2003@gmail.com', 'cash on delivery', '9,Jalan Setia Nusantara U13/19f, Setia Eco Park, 40170, Shah Alam, Malaysia', 'Limau Ice (4 x 1) - ', 4, '2023-10-30 19:11:03', 'pending'),
(29, 8, 'Chua Kim Yao', '1234567890', 'kimyao2003@gmail.com', 'cash on delivery', '9,Jalan Setia Nusantara U13/19f, Setia Eco Park, 40170, Shah Alam, Malaysia', 'Chicken Burger (10 x 1) - ', 10, '2023-10-30 19:24:25', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `rating` int(10) NOT NULL,
  `details` varchar(100) NOT NULL,
  `type` varchar(100) NOT NULL,
  `size` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `rating`, `details`, `type`, `size`, `image`) VALUES
(27, 'Chicken Burger', 'main dish', 10, 5, 'A very classic Chicken BURGER!!!', 'Non Veg', 'normal', 'burger-2.png'),
(28, 'Limau Ice', 'beverage', 4, 4, 'Limau and Ice ~', 'Cold', 'normal', 'drink-3.png'),
(29, 'Beef Burger', 'main dish', 12, 4, 'A very classic Beef BURGER!!!', 'Non Veg', 'normal', 'burger-1.png'),
(30, 'Chocolate Cake', 'desserts', 8, 5, 'Sweeeeeeeeeeeeeeeet!', 'Cold', 'normal', 'dessert-2.png'),
(31, 'Pizza', 'main dish', 10, 5, 'A very classic Pizza!!!', 'Non Veg', 'large', 'pizza-3.png');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `number` varchar(10) NOT NULL,
  `pax` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `user_id`, `name`, `email`, `date`, `time`, `number`, `pax`) VALUES
(1, 0, 'Chua Kim Yao', 'kimyao2003@gmail.com', '2023-10-23', '20:46:00', '1234567890', 3),
(2, 8, 'Chua Kim Yao', 'kimyao2003@gmail.com', '2023-11-15', '20:54:00', '1234567890', 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(8, 'Chua Kim Yao', 'kimyao2003@gmail.com', '1234567890', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '9,Jalan Setia Nusantara U13/19f, Setia Eco Park, 40170, Shah Alam, Malaysia'),
(10, 'Sofea', 'Sofea@gmail.com', '4561237890', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '9,Jalan Setia Nusantara U13/19f, Setia Eco Park, 40170, Selangor , Shah Alam'),
(13, 'Joyi', 'Joyi@gmail.com', '9874563210', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
