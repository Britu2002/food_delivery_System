-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307
-- Generation Time: Dec 10, 2025 at 10:47 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zaapin_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `date`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin', '2025-03-27 12:43:32');

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `userid` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `aadhar_number` varchar(50) DEFAULT NULL,
  `aadhar_copy` varchar(150) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','busy') DEFAULT 'Active',
  `res_id` int(11) DEFAULT NULL,
  `password` varchar(30) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`userid`, `fullname`, `mobile`, `email`, `address`, `city`, `pincode`, `aadhar_number`, `aadhar_copy`, `photo`, `status`, `res_id`, `password`, `createdon`) VALUES
(47, 'Lakshay Rajput', '9767845345', 'lakshay@gmail.com', 'Phool Bhag', 'Gwalior', '474005', '767656456745', 'adharcard.png', '1739467494_testimonial-2.jpg', 'Active', 3, '123', '2025-03-22 10:53:57'),
(48, 'Kashish thakur', '9786567567', 'kashish@gmail.com', 'City Center', 'Gwalior', '474001', '876756456345', 'adharcard.png', 'testimonial-3.jpg', 'Active', 4, '123', '2025-03-27 09:50:49'),
(49, 'Ranveer Rajvat', '9645645656', 'ranveer@gmail.com', 'City Center', 'Gwalior', '474005', '123456789012', 'adharcard.png', 'testimonial-3.jpg', 'Active', 6, '123', '2025-04-06 08:53:10'),
(50, 'Bharat Verma', '9756454567', 'bverma@gmail.com', 'Huzrat pool', 'Gwalior', '474002', '123445656789', 'adharcard.png', 'team-4.jpg', 'Active', 11, '12345', '2025-04-19 15:52:54');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryid` int(11) NOT NULL,
  `categoryname` varchar(100) NOT NULL,
  `image` varchar(150) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `categoryname`, `image`, `createdon`) VALUES
(40, 'pizza', '1742535522_pizza2.jpg', '2025-03-21 05:38:42'),
(41, 'Burger', '1745912648_burger_resto.jpg', '2025-03-21 05:38:55'),
(43, 'Chiken', '1743157914_chiken_biryani.jpg', '2025-03-28 10:31:54'),
(44, 'Desserts', '1743157933_cakes.jpeg', '2025-03-28 10:32:13'),
(46, 'Sandwich', '1743158024_cheese_sandwich.jpg', '2025-03-28 10:33:44'),
(47, 'Chinese', '1743158067_chowmin.jpg', '2025-03-28 10:34:27'),
(50, 'Drinks', '1745912812_drinks.webp', '2025-04-19 07:27:52'),
(52, 'choclate', '1746096987_choclate.jpg', '2025-05-01 10:56:27');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `cid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobile` bigint(11) NOT NULL,
  `address` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `password` varchar(10) NOT NULL,
  `img` varchar(150) NOT NULL,
  `status` varchar(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `name`, `email`, `mobile`, `address`, `city`, `pincode`, `password`, `img`, `status`, `date`) VALUES
(6, 'Ritu Bansal', 'bansalritu2002@gmail.com', 9301115005, 'DD-Nagar', 'Gwalior', '474005', '123', '', 'Active', '2025-03-22 10:14:38');

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `coupenid` int(11) NOT NULL,
  `coupencode` varchar(100) NOT NULL,
  `coupenpercentage` varchar(100) NOT NULL,
  `min_value` int(11) NOT NULL,
  `coupendesp` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `coupenophtoto` varchar(150) NOT NULL,
  `expiredate` varchar(100) NOT NULL,
  `created_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `offers`
--

INSERT INTO `offers` (`coupenid`, `coupencode`, `coupenpercentage`, `min_value`, `coupendesp`, `status`, `coupenophtoto`, `expiredate`, `created_date`) VALUES
(59, 'OFFER30', '30', 300, 'min order 300', 1, '1739607338_30_off.jpg', '2026-02-15', '2025-02-15'),
(69, 'NEW100', '20', 200, 'new User', 0, '1739610177_20percentoffer.webp', '2026-02-15', '2025-02-15'),
(70, 'NEW80', '20', 200, 'new User', 1, '1739610225_20percentoffer.webp', '2027-02-01', '2025-02-15'),
(71, 'OFFER100', '50', 1000, 'min order 1000', 1, '1740558675_code.jpg', '2026-02-26', '2025-02-26'),
(72, 'WELCOME10', '10', 500, 'Get 10% off on your first order', 1, '1740910451_welcome10.webp', '2026-04-01', '2025-03-02'),
(73, 'DIWALI20', '20', 500, 'Special Diwali 20% off', 1, '1740910556_20percentoffer.webp', '2029-03-02', '2025-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_number` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `resid` int(11) NOT NULL,
  `coupen_id` int(11) DEFAULT NULL,
  `subtotal` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  `total_items` int(11) NOT NULL,
  `payment_method` enum('card','COD','upi','paypal') NOT NULL DEFAULT 'COD',
  `payment_status` enum('Pending','Complete','Failed') NOT NULL DEFAULT 'Pending',
  `delivery_status` varchar(10) DEFAULT '1',
  `delivery_boy_id` int(11) DEFAULT NULL,
  `order_otp` int(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_number`, `customer_id`, `resid`, `coupen_id`, `subtotal`, `total`, `discount`, `total_items`, `payment_method`, `payment_status`, `delivery_status`, `delivery_boy_id`, `order_otp`, `created_at`) VALUES
(125, 'ORD1742639720', 6, 3, 70, 240, 192, 48, 1, 'COD', 'Pending', '4', 47, 876784, '2025-03-22 06:05:20'),
(130, 'ORD1743247449', 6, 4, 70, 440, 352, 88, 3, 'card', 'Complete', '1', NULL, 497658, '2025-03-29 06:54:09'),
(131, 'ORD1743247562', 6, 3, NULL, 150, 150, 0, 1, 'upi', 'Complete', '4', 47, 894702, '2025-03-29 06:56:02'),
(132, 'ORD1743247664', 6, 4, NULL, 150, 150, 0, 1, 'paypal', 'Complete', '6', 48, 772118, '2025-03-29 06:57:44'),
(133, 'ORD1743573787', 6, 4, 70, 440, 352, 88, 3, 'COD', 'Pending', '5', 48, 664122, '2025-04-02 02:33:07'),
(134, 'ORD1743928780', 6, 3, 69, 480, 384, 96, 1, 'COD', 'Complete', '6', 47, 589702, '2025-04-06 05:09:40'),
(135, 'ORD1743929678', 6, 6, 69, 160, 128, 32, 1, 'upi', 'Complete', '4', 49, 948895, '2025-04-06 05:24:38'),
(136, 'ORD1743933447', 6, 3, 70, 360, 288, 72, 1, 'COD', 'Pending', '3', NULL, 539041, '2025-04-06 06:27:27'),
(137, 'ORD1745071701', 6, 4, NULL, 350, 350, 0, 2, 'COD', 'Complete', '6', 48, 486055, '2025-04-19 10:38:21'),
(138, 'ORD1745077064', 6, 11, 70, 472, 378, 94, 3, 'COD', 'Complete', '6', 50, 244692, '2025-04-19 12:07:44'),
(139, 'ORD1746097265', 6, 4, 59, 245, 172, 74, 2, 'COD', 'Complete', '6', 48, 222433, '2025-05-01 07:31:05'),
(140, 'ORD1746879192', 6, 4, NULL, 400, 400, 0, 2, 'upi', 'Complete', '1', NULL, 914892, '2025-05-10 08:43:12'),
(141, 'ORD1747110715', 6, 12, 70, 160, 128, 32, 1, 'COD', 'Pending', '1', NULL, 589493, '2025-05-13 01:01:55'),
(142, 'ORD1751864810', 6, 4, 70, 600, 480, 120, 2, 'COD', 'Complete', '6', 48, 483196, '2025-07-07 01:36:50'),
(143, 'ORD1764139850', 6, 4, NULL, 1350, 1350, 0, 4, 'upi', 'Complete', '1', NULL, 421793, '2025-11-26 02:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `quantity`) VALUES
(94, 125, 124, 2),
(102, 130, 126, 1),
(103, 130, 125, 1),
(104, 130, 127, 1),
(105, 131, 124, 1),
(106, 132, 125, 1),
(107, 133, 126, 1),
(108, 133, 125, 1),
(109, 133, 130, 1),
(110, 134, 124, 4),
(111, 135, 132, 1),
(112, 136, 124, 3),
(113, 137, 125, 1),
(114, 137, 126, 1),
(115, 138, 136, 1),
(116, 138, 137, 1),
(117, 138, 138, 1),
(118, 139, 126, 1),
(119, 139, 125, 1),
(120, 140, 126, 1),
(121, 140, 130, 1),
(122, 141, 142, 2),
(123, 142, 125, 1),
(124, 142, 126, 3),
(125, 143, 129, 4),
(126, 143, 125, 1),
(127, 143, 126, 1),
(128, 143, 130, 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `payment_method` enum('card','upi','paypal','') NOT NULL,
  `payment_status` enum('Pending','Complete','Failed','Refunded') DEFAULT 'Pending',
  `transaction_id` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `customer_id`, `order_id`, `amount`, `payment_method`, `payment_status`, `transaction_id`, `created_at`) VALUES
(72, 6, 130, 352, 'card', 'Complete', 'TXN1743247449', '2025-03-29 06:54:09'),
(73, 6, 131, 150, 'upi', 'Complete', 'TXN1743247562', '2025-03-29 06:56:02'),
(74, 6, 132, 150, 'paypal', 'Complete', 'TXN1743247664', '2025-03-29 06:57:44'),
(75, 6, 135, 128, 'upi', 'Complete', 'TXN1743929678', '2025-04-06 05:24:38'),
(76, 6, 140, 400, 'upi', 'Complete', 'TXN1746879192', '2025-05-10 08:43:12'),
(77, 6, 143, 1350, 'upi', 'Complete', 'TXN1764139850', '2025-11-26 02:20:50');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  `resid` int(11) NOT NULL,
  `prodect_type` int(2) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `desp` text NOT NULL,
  `image` varchar(200) NOT NULL,
  `display_price` int(11) NOT NULL,
  `recommended` enum('Yes','No') DEFAULT 'No',
  `createdon` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productid`, `categoryid`, `resid`, `prodect_type`, `productname`, `desp`, `image`, `display_price`, `recommended`, `createdon`) VALUES
(124, 41, 3, 1, 'classic burger', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt nulla expedita adipisci odio cumque maiores iure, minima facere. Fugiat repellendus obcaecati reprehenderit rerum in! Eligendi necessitatibus est quis ipsa soluta dolores nihil?', '1742540029_burgers.jpg', 150, 'Yes', '2025-03-21 06:53:49'),
(125, 40, 4, 1, 'veg', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt nulla expedita adipisci odio cumque maiores iure, minima facere. Fugiat repellendus obcaecati reprehenderit rerum in! Eligendi necessitatibus est quis ipsa soluta dolores nihil?', 'chessepizza.jpg', 150, 'Yes', '2025-03-21 08:27:14'),
(126, 40, 4, 1, 'corn pizza', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt nulla expedita adipisci odio cumque maiores iure, minima facere. Fugiat repellendus obcaecati reprehenderit rerum in! Eligendi necessitatibus est quis ipsa soluta dolores nihil?', 'cron pizza.jpg', 200, 'Yes', '2025-03-21 08:27:43'),
(127, 41, 4, 1, 'new burger', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt nulla expedita adipisci odio cumque maiores iure, minima facere. Fugiat repellendus obcaecati reprehenderit rerum in! Eligendi necessitatibus est quis ipsa soluta dolores nihil?', '1742644970_burgers.jpg', 200, 'Yes', '2025-03-22 12:02:50'),
(128, 40, 5, 1, 'tamto pizza', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt nulla expedita adipisci odio cumque maiores iure, minima facere. Fugiat repellendus obcaecati reprehenderit rerum in! Eligendi necessitatibus est quis ipsa soluta dolores nihil?', '1742646544_tamoto pizza.jpg', 200, 'Yes', '2025-03-22 12:29:04'),
(129, 44, 4, 1, 'cheese cake', 'lorem lorem lorem 34 asdgn l etlr ,be,k ektyr herk, kr etyr lgds ', '1743174889_cheesecake.webp', 200, 'Yes', '2025-03-28 15:14:49'),
(130, 40, 4, 1, 'new pizza', 'asddgfhkjl liestry leitry ltbl btrly blretrtb lybtl bl  trt', '1743174938_pizza2.jpg', 200, 'Yes', '2025-03-28 15:15:38'),
(132, 46, 6, 1, 'veg sandwich', 'jkdf bsdkx rebtkxd tk tekrb ekurdb kutb tlbz burzhk ', '1743929659_sandwich.jpg', 200, 'Yes', '2025-04-06 08:54:19'),
(136, 50, 11, 1, 'Oreo Shake', 'Oreo Milkshake Recipe - A super easy milkshake made with vanilla ice cream, milk, and Oreo cookies!  This sweet treat is a hit with the whole family on a hot ', '1745047751_oreo-shake.jpg', 290, 'Yes', '2025-04-19 07:29:11'),
(137, 50, 11, 1, 'Ice Cream Shake', 'There is nothing better than a perfect milkshake Luckily, making one at home is extremely ', '1745047806_Ice-cream-Milkshake.png', 150, 'Yes', '2025-04-19 07:30:06'),
(138, 50, 11, 1, 'Caramel Milk Shake', 'This deliciously decadent caramel milkshake is quick and easy to make at home You’ll just need three ingredients: vanilla ice cream, milk, and caramel–homemade or store-bought is just ', '1745048327_caramelmilkshake.jpg', 150, 'Yes', '2025-04-19 07:38:47'),
(139, 44, 6, 1, 'colcate Pie', 'Special Desert, Brown sugar pie is a basic pie from Quebec, Canada In French, it is Tarte au Sucre Brun', '1745073176_brown-pie.jpg', 500, 'Yes', '2025-04-19 14:32:56'),
(140, 44, 6, 1, 'Caramel Sweet', 'hese salted caramels are soft, chewy and perfectly melt away in your mouth Rich and delicious, this easy caramel sauce is perfect for all sorts ', '1745073254_caramel-sweet.jpg', 450, 'Yes', '2025-04-19 14:34:14'),
(142, 47, 12, 1, 'noodles', 'the taste straight from chines street  ', '1747110467_chowmin.jpg', 100, 'Yes', '2025-05-13 04:27:47');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `resid` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `o_hr` varchar(20) NOT NULL,
  `c_hr` varchar(20) NOT NULL,
  `o_days` varchar(20) NOT NULL,
  `addr` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `image` varchar(200) NOT NULL,
  `status` varchar(10) NOT NULL,
  `Working_status` varchar(7) NOT NULL DEFAULT 'open',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`resid`, `title`, `email`, `phone`, `o_hr`, `c_hr`, `o_days`, `addr`, `city`, `pincode`, `image`, `status`, `Working_status`, `date`) VALUES
(3, 'burger Food', 'burgerfood@gmail.com', 1234567890, '10am', '10pm', 'Mon-Sat', 'Phool Bhag', 'gwalior', '474005', 'burgers_food.jpg', 'active', 'open', '2025-04-22 12:44:06'),
(4, 'cafe', 'cafe@gmail.com', 7654564567, '11am', '10pm', 'Mon-Fri', 'anand nagar', 'gwalior', '474005', 'cup-coffee-with-heart-drawn-foam.jpg', 'active', 'open', '2025-04-22 12:51:10'),
(5, 'Smottes', 'smootes@gmail.com', 9785645345, '10am', '11pm', '24hr-x7', 'City Centre Near Patel Nagar', 'Gwalior', '474011', 'drink-cafe.jpg', 'active', 'open', '2025-04-22 12:50:51'),
(6, 'Sutlan Dine', 'sultanDine@gmail.com', 4543234567, '10am', '10pm', 'Mon-Sat', 'City Center', 'Gwalior', '474005', 'optp.jpg', 'active', 'open', '2025-04-22 12:51:11'),
(7, 'Mc Donalds', 'mcDonals@gmail.com', 7865645345, '10am', '10pm', 'Mon-Sat', 'City Center', 'Gwalior', '474005', 'burger_resto1.jpg', 'active', 'open', '2025-04-23 11:50:55'),
(11, 'Organic Arcadian Food', 'Arcadian@gmail.com', 9878675678, '11am', '11pm', '24hr-x7', 'City Center', 'Gwalior', '474002', 'mug_resto.jpg', 'active', 'open', '2025-04-29 07:47:53'),
(12, 'tasty Food', 'tastyfood@gmail.com', 9765645645, '11am', '11pm', 'Mon-Sat', 'Anand Nagar', 'Gwalior', '474001', 'vertical-shot-bright-neon-lights-spelling-tasty-food.jpg', 'active', 'open', '2025-05-13 14:44:28'),
(14, 'indian Food Resto', 'indiafood@gmail.com', 9876567890, '11am', '11pm', 'Mon-Sat', 'City Center', 'Gwalior', '474001', 'paobhaji.jpg', 'active', 'open', '2025-05-13 04:28:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `agent_ibfk_1` (`res_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`coupenid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `delivery_boy_id` (`delivery_boy_id`),
  ADD KEY `coupen_code` (`coupen_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `resid` (`resid`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_items_ibfk_1` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `payments_ibfk_3` (`order_id`),
  ADD KEY `payments_ibfk_2` (`customer_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productid`),
  ADD KEY `categoryid` (`categoryid`),
  ADD KEY `product_ibfk_2` (`resid`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`resid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `coupenid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `resid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `agent`
--
ALTER TABLE `agent`
  ADD CONSTRAINT `agent_ibfk_1` FOREIGN KEY (`res_id`) REFERENCES `restaurant` (`resid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`delivery_boy_id`) REFERENCES `agent` (`userid`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`coupen_id`) REFERENCES `offers` (`coupenid`),
  ADD CONSTRAINT `orders_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`cid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_5` FOREIGN KEY (`resid`) REFERENCES `restaurant` (`resid`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`productid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`cid`),
  ADD CONSTRAINT `payments_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryid`) REFERENCES `category` (`categoryid`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`resid`) REFERENCES `restaurant` (`resid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
