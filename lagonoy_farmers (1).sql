-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 30, 2024 at 01:19 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */
;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */
;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */
;
/*!40101 SET NAMES utf8mb4 */
;
--
-- Database: `lagonoy_farmer`
--

-- --------------------------------------------------------
--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT current_timestamp(6)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `username`, `password`, `created_at`)
VALUES (
    2,
    'Admin',
    '$2y$10$YaAikClp..cGjszuqTKJTuZ1877JdUcVUpmVCh4MUJkdw./7sQ.zu',
    '2024-10-08 22:44:07.202538'
  );
-- --------------------------------------------------------
--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (
    `id`,
    `user_id`,
    `product_id`,
    `quantity`,
    `added_at`
  )
VALUES (7, 15, 1, 1, '2024-10-19 15:39:24');
-- --------------------------------------------------------
--
-- Table structure for table `farm_info`
--

CREATE TABLE `farm_info` (
  `farm_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `farm_street` varchar(50) NOT NULL,
  `farm_barangay` varchar(50) NOT NULL,
  `physical_area` decimal(10, 2) NOT NULL,
  `total_production` decimal(10, 2) NOT NULL,
  `tenurial_status` enum('Owner', 'Tenant', 'Renter’, ‘Not_Applicable') NOT NULL,
  `soil_type` enum(
    'Clay',
    'Sandy',
    'Sandy_Clay',
    'Sandy_Loam’, ‘Not_Applicable'
  ) NOT NULL,
  `shop_name` varchar(50) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `farm_info`
--

INSERT INTO `farm_info` (
    `farm_id`,
    `user_id`,
    `farm_street`,
    `farm_barangay`,
    `physical_area`,
    `total_production`,
    `tenurial_status`,
    `soil_type`,
    `shop_name`
  )
VALUES (
    12,
    14,
    'ZONE 7',
    'SAN ISIDRO NORTE',
    0.50,
    0.50,
    'Tenant',
    'Clay',
    'Sarah\'s Poultry Shop'
  ),
  (
    13,
    16,
    'Consequatur Sed sus',
    'Deserunt fugiat ver',
    82.00,
    30.00,
    '',
    '',
    'Uragon\'s Calamansi Shop'
  );
-- --------------------------------------------------------
--
-- Table structure for table `fertilizers`
--

CREATE TABLE `fertilizers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `applications` text NOT NULL,
  `method` text NOT NULL,
  `best_for` text NOT NULL,
  `image` blob NOT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `fertilizers`
--

INSERT INTO `fertilizers` (
    `id`,
    `name`,
    `description`,
    `applications`,
    `method`,
    `best_for`,
    `image`,
    `archived`,
    `is_archived`
  )
VALUES (
    2,
    'ATLAS UREA 1',
    'Atlas Urea Fertilizer is a high-concentration nitrogen fertilizer that contains approximately 46% nitrogen (N), making it one of the most potent nitrogen sources for plants. It typically appears as small, white granules or prills and is easily soluble in water, allowing for efficient absorption by plants. Nitrogen is a critical nutrient for plant development, especially for promoting leafy growth, protein synthesis, and overall crop yield.',
    'Atlas Urea Fertilizer is used in a wide variety of agricultural and horticultural applications to enhance plant growth and improve crop yields.',
    'There are several ways to apply Atlas Urea Fertilizer to crops, depending on the crop type, soil conditions, and environmental factors. Some methods include broadcasting, side-dressing, fertigation, and foliar spraying.',
    'Atlas Urea Fertilizer is best suited for Nitrogen-deficient soils.',
    0x41544c415320555245412e706e67,
    0,
    0
  );
-- --------------------------------------------------------
--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `incoming_id` int(11) NOT NULL,
  `outgoing_id` int(11) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (
    `msg_id`,
    `message`,
    `incoming_id`,
    `outgoing_id`
  )
VALUES (1, 'heyy', 15, 16),
  (2, 'shhh', 15, 16),
  (3, 'heyy man', 17, 16),
  (4, 'heyy man', 16, 18),
  (5, 'heyy', 16, 16),
  (6, 'heyyyy', 14, 16),
  (7, 'to jane', 14, 16),
  (8, 'to caldwelll', 18, 16),
  (9, 'heyy', 19, 16),
  (10, 'what', 16, 19),
  (11, 'im gonna buy', 16, 19),
  (12, 'what', 16, 19),
  (13, 'somethingnice', 19, 16),
  (14, 'ehh?', 16, 19),
  (15, 'helloooo', 14, 16);
-- --------------------------------------------------------
--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10, 2) NOT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `order_status` varchar(20) DEFAULT 'Pending'
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (
    `order_id`,
    `user_id`,
    `product_id`,
    `quantity`,
    `total_price`,
    `order_date`,
    `order_status`
  )
VALUES (
    1,
    15,
    1,
    1,
    150.00,
    '2024-10-08 22:39:24',
    'Paid'
  ),
  (
    2,
    15,
    1,
    1,
    150.00,
    '2024-10-08 22:41:35',
    'Pending'
  ),
  (
    3,
    15,
    1,
    1,
    150.00,
    '2024-10-09 23:12:21',
    'Pending'
  ),
  (
    4,
    15,
    1,
    1,
    150.00,
    '2024-10-15 13:03:57',
    'Pending'
  ),
  (
    5,
    15,
    1,
    1,
    150.00,
    '2024-10-15 14:02:46',
    'Pending'
  ),
  (
    6,
    15,
    1,
    1,
    150.00,
    '2024-10-15 14:03:00',
    'Pending'
  ),
  (
    7,
    15,
    1,
    1,
    150.00,
    '2024-10-19 15:39:28',
    'Pending'
  ),
  (
    8,
    15,
    1,
    1,
    150.00,
    '2024-10-19 15:41:09',
    'Pending'
  );
-- --------------------------------------------------------
--
-- Table structure for table `personal_info`
--

CREATE TABLE `personal_info` (
  `info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `extension` varchar(10) DEFAULT NULL,
  `sex` enum('Male', 'Female') NOT NULL,
  `civil_status` enum('Single', 'Married', 'Widow') DEFAULT NULL,
  `dob` date NOT NULL,
  `street` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `municipality` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `household_members` int(11) DEFAULT NULL,
  `educational_attainment` enum(
    'Elementary_Level',
    'Elementary_Graduate',
    'High_School_Level',
    'High_School_Graduate',
    'Senior_High_Level',
    'Senior_High_Graduate',
    'College_Level',
    'College_Graduate’, ‘Not_Applicable'
  ) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (
    `info_id`,
    `user_id`,
    `surname`,
    `firstname`,
    `middlename`,
    `extension`,
    `sex`,
    `civil_status`,
    `dob`,
    `street`,
    `barangay`,
    `municipality`,
    `province`,
    `mobile_number`,
    `household_members`,
    `educational_attainment`
  )
VALUES (
    14,
    14,
    'ROSERO',
    'SARAH JANE',
    'DIZON',
    'NONE',
    'Female',
    'Single',
    '2002-06-28',
    'ZONE 1',
    'SAN ISIDRO NORTRE',
    'LAGONOY',
    'CAMARINES SUR',
    '09304094230',
    4,
    'Elementary_Level'
  ),
  (
    15,
    15,
    'Purisima',
    'Kristine',
    'Pacis',
    'NONE',
    'Female',
    NULL,
    '2002-01-14',
    'ZONE 7',
    'SAN ISIDRO NORTRE',
    'LAGONOY',
    'CAMARINES SUR',
    '09304094230',
    NULL,
    'Elementary_Level'
  ),
  (
    16,
    16,
    'Hicks',
    'Chloe',
    'Dante Wells',
    'Kellie Dec',
    'Female',
    'Single',
    '1985-09-27',
    'Impedit est et ipsu',
    'Voluptatem fuga Rep',
    'Et voluptates debiti',
    'Ipsa maxime incidid',
    '09161670317',
    1,
    'College_Level'
  ),
  (
    17,
    17,
    'Church',
    'Sade',
    'Darryl Morrow',
    'Yvette Joh',
    'Male',
    NULL,
    '2001-08-26',
    'Dolor autem id odio',
    'Porro inventore quid',
    'Id reprehenderit sin',
    'Cupidatat quae minus',
    '09123456789',
    NULL,
    'Elementary_Level'
  ),
  (
    18,
    18,
    'Caldwell',
    'Mira',
    'Isadora Cabrera',
    'Wayne Beck',
    'Female',
    NULL,
    '2024-06-26',
    'Architecto eligendi',
    'Doloremque non nihil',
    'Quia perspiciatis s',
    'Est duis voluptas at',
    '09123456782',
    NULL,
    'Elementary_Level'
  ),
  (
    19,
    19,
    'Sinfuego',
    'Edzel John',
    'C.',
    'Kellie Dec',
    'Male',
    NULL,
    '2024-10-31',
    'Cabariwan',
    'afsdfsdfdsf',
    'asdfdsfdsfdsf',
    'Camarines Sur',
    '09161670317',
    NULL,
    'Elementary_Level'
  );
-- --------------------------------------------------------
--
-- Table structure for table `pest`
--

CREATE TABLE `pest` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `causes` text NOT NULL,
  `solutions` text NOT NULL,
  `image` blob NOT NULL,
  `archived` tinyint(1) DEFAULT 0,
  `is_archived` tinyint(1) DEFAULT 0
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `pest`
--

INSERT INTO `pest` (
    `id`,
    `name`,
    `causes`,
    `solutions`,
    `image`,
    `archived`,
    `is_archived`
  )
VALUES (
    1,
    'Purple Scale Pests',
    'Causes of Purple',
    'Solutions',
    0x70657374732f507572706c65205363616c652e6a7067,
    0,
    0
  );
-- --------------------------------------------------------
--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_id` varchar(50) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10, 2) DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `product_photo` blob DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `products`
--

INSERT INTO `products` (
    `id`,
    `product_id`,
    `product_name`,
    `description`,
    `price`,
    `posting_date`,
    `product_photo`,
    `user_id`
  )
VALUES (
    2,
    '0001',
    'Lemonsito Citrus Juice',
    'Calamansi juice is a refreshing and tangy citrus drink packed with vitamin C, perfect for boosting your immune system and quenching thirst naturally.',
    150.00,
    NULL,
    0x70726f64756374732f6a2e6a7067,
    14
  ),
  (
    3,
    '222211111',
    'Poging Calamansi',
    'Enim impedit minus ',
    306.00,
    NULL,
    0x70726f64756374732f6361742e6a7067,
    16
  );
-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(70) NOT NULL,
  `role` enum('Farmer', 'Buyer') NOT NULL,
  `created_at` timestamp(6) NULL DEFAULT current_timestamp(6)
) ENGINE = MyISAM DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (
    `user_id`,
    `username`,
    `password`,
    `role`,
    `created_at`
  )
VALUES (
    15,
    'tine',
    '$2y$10$hdToiwWme.wnkD.0htiISukAEjkv50h044xqFFPw3F3OCS4exmuPm',
    'Buyer',
    '2024-10-08 22:38:25.286725'
  ),
  (
    14,
    'ed',
    '$2y$10$Hx2zUxSCyFRo20nKSwZvjO24OwTexWxhMRzKYeI1q8HVgDvu8Wdy2',
    'Farmer',
    '2024-10-08 22:24:15.917155'
  ),
  (
    16,
    'user100',
    '$2y$10$Z443XHHsiCrZELWqcbqEc.K91DlD7cp3c8px5FtQDV.z5JRkrF4GG',
    'Farmer',
    '2024-10-26 13:25:21.579809'
  ),
  (
    17,
    'user200',
    '$2y$10$oO0rIHVjYsHrFPyICJmZ5e5c6ZyniqltqMbEnQ42y.6kkiSIPLBpa',
    'Buyer',
    '2024-10-26 14:01:44.817363'
  ),
  (
    18,
    'user300',
    '$2y$10$32C.rkipIszXFrru8AfeDuZOXWkw2m5JW7Bu/lUMTZgBwmxxk4mhW',
    'Buyer',
    '2024-10-28 09:24:29.123454'
  ),
  (
    19,
    'user400',
    '$2y$10$fpZRRDO5nqFe1U6BY/p92uX39qKUtI/F1Orog/H3z4.TeOH/4B3dS',
    'Buyer',
    '2024-10-28 16:27:58.972454'
  );
--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
ADD PRIMARY KEY (`user_id`);
--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);
--
-- Indexes for table `farm_info`
--
ALTER TABLE `farm_info`
ADD PRIMARY KEY (`farm_id`),
  ADD KEY `user_id` (`user_id`);
--
-- Indexes for table `fertilizers`
--
ALTER TABLE `fertilizers`
ADD PRIMARY KEY (`id`);
--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
ADD PRIMARY KEY (`msg_id`);
--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);
--
-- Indexes for table `personal_info`
--
ALTER TABLE `personal_info`
ADD PRIMARY KEY (`info_id`),
  ADD KEY `user_id` (`user_id`);
--
-- Indexes for table `pest`
--
ALTER TABLE `pest`
ADD PRIMARY KEY (`id`);
--
-- Indexes for table `products`
--
ALTER TABLE `products`
ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);
--
-- Indexes for table `users`
--
ALTER TABLE `users`
ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 8;
--
-- AUTO_INCREMENT for table `farm_info`
--
ALTER TABLE `farm_info`
MODIFY `farm_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 14;
--
-- AUTO_INCREMENT for table `fertilizers`
--
ALTER TABLE `fertilizers`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 3;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 16;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 9;
--
-- AUTO_INCREMENT for table `personal_info`
--
ALTER TABLE `personal_info`
MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 20;
--
-- AUTO_INCREMENT for table `pest`
--
ALTER TABLE `pest`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 2;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 4;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 20;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */
;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */
;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */
;