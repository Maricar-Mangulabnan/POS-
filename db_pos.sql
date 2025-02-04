-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2023 at 03:25 AM
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
-- Database: `db_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `orderhistory`
--

CREATE TABLE `orderhistory` (
  `historyID` int(11) NOT NULL,
  `Date` text NOT NULL,
  `CustomerName` varchar(50) NOT NULL,
  `CashierID` int(11) NOT NULL,
  `Total` int(11) NOT NULL,
  `Amount_Given` int(11) NOT NULL,
  `Change_` int(11) NOT NULL,
  `Status_` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderhistory`
--

INSERT INTO `orderhistory` (`historyID`, `Date`, `CustomerName`, `CashierID`, `Total`, `Amount_Given`, `Change_`, `Status_`) VALUES
(89, '2023-12-11', 'test', 9, 2135, 2150, 15, ''),
(90, '2023-12-11', 'test', 9, 70, 100, 30, ''),
(91, '2023-12-11', 'test', 9, 70, 100, 30, '');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `orderID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `Qty` int(11) NOT NULL,
  `orderHistoryID` int(11) NOT NULL,
  `Archive` varchar(50) NOT NULL,
  `Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`orderID`, `productID`, `Qty`, `orderHistoryID`, `Archive`, `Date`) VALUES
(238, 2, 10, 89, 'Yes', '2023-12-11'),
(239, 3, 5, 89, 'Yes', '2023-12-11'),
(240, 7, 5, 89, 'Yes', '2023-12-11'),
(241, 8, 5, 89, 'Yes', '2023-12-11'),
(242, 9, 2, 89, 'Yes', '2023-12-11'),
(243, 10, 5, 89, 'Yes', '2023-12-11'),
(244, 10, 1, 90, 'Yes', '2023-12-11'),
(253, 2, 1, 91, 'Yes', '2023-12-11');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `Code` bigint(100) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Stock` int(11) NOT NULL,
  `SRP` int(11) NOT NULL,
  `MarkupPrice` int(11) NOT NULL,
  `SoldQty` int(11) NOT NULL,
  `LossQty` int(11) NOT NULL,
  `ReturnQty` int(11) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Archive` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `Code`, `Name`, `Stock`, `SRP`, `MarkupPrice`, `SoldQty`, `LossQty`, `ReturnQty`, `Status`, `Archive`) VALUES
(2, 123456789, 'Presto Peanut', 89, 60, 70, 11, 0, 0, 'Active', ''),
(3, 1234567890, 'Ligo Sardines Spicy', 95, 30, 38, 5, 0, 0, 'Active', ''),
(7, 123456789, 'Gardenia Cheese Buns', 95, 50, 67, 5, 0, 0, 'Active', ''),
(8, 123456789, '555 Spicy Sardines', 95, 30, 40, 5, 0, 0, 'Active', ''),
(9, 1234567890, 'Skippy Peanut Butter Classic', 98, 150, 180, 2, 0, 0, 'Active', ''),
(10, 123456789, 'Cream 0 Strawberry', 94, 60, 70, 6, 0, 0, 'Discontinued', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Contact` bigint(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL,
  `Status` varchar(100) NOT NULL,
  `Archive` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `Name`, `Contact`, `Email`, `Password`, `Position`, `Status`, `Archive`) VALUES
(3, 'John Michael', 9123456789, 'JMGoco416@gmail.com', 'pass123', 'Manager', 'Active', ''),
(4, 'Aero Dela Pena', 9987654321, 'AeroDelaPena@gmail.com', 'aero123', 'Inventory Clerk', 'Active', ''),
(6, 'Riane Gamboa', 9192837465, 'RianeGamboa@gmail.com', 'pass123', 'Cashier', 'Active', 'No\r\n\r\n'),
(9, 'Maricar Mangulabnan', 9123456789, 'maricarmangulabnan@gmail.com', 'pass123', 'Admin', 'Active', 'No'),
(10, 'Howen Asuncion', 9123456789, 'howen@gmail.com', 'pass123', 'Cashier', 'Active', ''),
(11, 'Janzen', 9123456789, 'janzen@gmail.com', 'pass123', 'Inventory Clerk', 'Active', ''),
(12, 'test 1', 0, 'test@gmail.com', 'pass123', 'Cashier', 'Inactive', 'Yes'),
(13, 'test 12', 9123456789, 'test123@gmail.com', '123', 'Cashier', 'Inactive', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD PRIMARY KEY (`historyID`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderhistory`
--
ALTER TABLE `orderhistory`
  MODIFY `historyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
