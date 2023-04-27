-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 29, 2023 at 06:05 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mobile`
--

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(10) UNSIGNED NOT NULL,
  `banking_type` varchar(55) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `ac_name` varchar(255) DEFAULT NULL,
  `ac_no` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `banks`
--

INSERT INTO `banks` (`id`, `banking_type`, `title`, `branch`, `sub_title`, `slug`, `ac_name`, `ac_no`, `image`, `description`, `address`, `mobile`, `email`, `active`, `hit_count`, `client_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'General Banking', 'Janata Bank', 'Dhaka', NULL, 'janata-bank', 'Hafizur Rahman', '19950', NULL, NULL, NULL, NULL, NULL, 'on', NULL, '1', '2', '', '2023-03-29 15:47:30', '2023-03-29 15:47:30'),
(2, 'Mobile Banking', 'Bkash', NULL, NULL, 'bkash', 'bKash Personal', '01711451033', NULL, NULL, NULL, NULL, NULL, 'on', NULL, '1', '2', '', '2023-03-29 15:47:45', '2023-03-29 15:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` int(11) NOT NULL,
  `client_id` varchar(55) DEFAULT NULL,
  `bank_id` varchar(255) NOT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `expense_id` varchar(55) DEFAULT NULL,
  `cashflow_id` varchar(100) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `amount_in` varchar(255) DEFAULT NULL,
  `amount_out` varchar(255) DEFAULT NULL,
  `current_balance` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_checks`
--

CREATE TABLE `bank_checks` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `check_no` varchar(255) DEFAULT NULL,
  `bank_id` varchar(55) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `customer_id` varchar(55) NOT NULL,
  `invoice_id` varchar(55) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `active` varchar(20) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cash_flows`
--

CREATE TABLE `cash_flows` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `bank_id` varchar(255) DEFAULT NULL,
  `company_id` varchar(111) DEFAULT NULL,
  `invoice_id` varchar(255) DEFAULT NULL,
  `expense_id` varchar(55) DEFAULT NULL,
  `investor_id` varchar(100) DEFAULT NULL,
  `cashflow_type` varchar(255) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `amount_in` varchar(255) DEFAULT NULL,
  `amount_out` varchar(255) DEFAULT NULL,
  `current_balance` varchar(255) DEFAULT NULL,
  `received_by` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `active` varchar(22) DEFAULT NULL,
  `date` varchar(111) DEFAULT NULL,
  `client_id` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(111) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `business_type` varchar(255) NOT NULL DEFAULT '''User''',
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `parent` varchar(255) DEFAULT NULL,
  `company_type` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `link_action` varchar(255) DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `title`, `sub_title`, `slug`, `parent`, `company_type`, `image`, `description`, `short_description`, `address`, `mobile`, `email`, `website`, `link_title`, `link_action`, `active`, `hit_count`, `client_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'ABC Company', NULL, 'abc-company', NULL, 'Company', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'on', NULL, '1', '2', '', '2023-03-29 15:48:15', '2023-03-29 15:48:15');

-- --------------------------------------------------------

--
-- Table structure for table `company_accounts`
--

CREATE TABLE `company_accounts` (
  `id` int(11) NOT NULL,
  `company_id` varchar(255) NOT NULL,
  `purchase_id` varchar(55) DEFAULT NULL,
  `expense_id` varchar(55) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `amount_in` varchar(255) DEFAULT NULL,
  `amount_out` varchar(255) DEFAULT NULL,
  `current_balance` varchar(255) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `applied_for` varchar(255) DEFAULT NULL,
  `discount_amount` float DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_on_purchase` float DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `start_from` datetime DEFAULT NULL,
  `end_to` datetime DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `proprietor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `category_id` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `customer_type` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `link_action` varchar(255) DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `title`, `proprietor`, `sub_title`, `slug`, `type`, `category_id`, `image`, `customer_type`, `description`, `short_description`, `address`, `mobile`, `email`, `link_title`, `link_action`, `active`, `hit_count`, `client_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'sdf', 'sdf', NULL, 'sdf', 'Indivisual', NULL, NULL, NULL, NULL, NULL, 'Dhaka', 'sdf', 'softwareeng.me@gmail.com', NULL, NULL, 'on', NULL, '1', '2', '', '2023-03-29 13:54:54', '2023-03-29 13:54:54');

-- --------------------------------------------------------

--
-- Table structure for table `customer_accounts`
--

CREATE TABLE `customer_accounts` (
  `id` int(11) NOT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `customer_id` varchar(255) NOT NULL,
  `invoice_id` varchar(55) DEFAULT NULL,
  `payment_id` varchar(55) DEFAULT NULL,
  `expense_id` varchar(55) DEFAULT NULL,
  `type` varchar(55) DEFAULT NULL,
  `amount_in` varchar(255) DEFAULT NULL,
  `amount_out` varchar(255) DEFAULT NULL,
  `current_balance` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daily_cash`
--

CREATE TABLE `daily_cash` (
  `id` int(11) NOT NULL,
  `date` varchar(111) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_lookups`
--

CREATE TABLE `data_lookups` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `data_type` varchar(255) NOT NULL,
  `active` varchar(25) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `updated_by` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `duties`
--

CREATE TABLE `duties` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `client_id` varchar(25) NOT NULL,
  `equipement_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `vendor_id` varchar(255) DEFAULT NULL,
  `employee_id` varchar(20) DEFAULT NULL,
  `start_reading` varchar(255) DEFAULT NULL,
  `stop_reading` varchar(55) DEFAULT NULL,
  `total_hours` varchar(55) DEFAULT NULL,
  `rate` varchar(55) DEFAULT NULL,
  `bill` varchar(55) DEFAULT NULL,
  `tracking_hours` varchar(55) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `payment_receive` varchar(55) DEFAULT NULL,
  `fuel_type` varchar(55) DEFAULT NULL,
  `fuel_qty` varchar(55) DEFAULT NULL,
  `fuel_rate` varchar(55) DEFAULT NULL,
  `fuel_cost` varchar(55) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `total_payment` varchar(255) DEFAULT NULL,
  `total_expense` varchar(55) DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `parent` varchar(255) DEFAULT NULL,
  `dept_id` varchar(20) DEFAULT NULL,
  `salary_type` varchar(255) DEFAULT NULL,
  `salary_amount` varchar(255) DEFAULT NULL,
  `employement_type` varchar(255) DEFAULT NULL,
  `joining_date` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `designation` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `link_action` varchar(255) DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `expense_type` varchar(255) DEFAULT NULL,
  `expense_type_sub` varchar(255) DEFAULT NULL,
  `product_id` varchar(22) DEFAULT NULL,
  `company_id` varchar(22) DEFAULT NULL,
  `customer_id` varchar(55) DEFAULT NULL,
  `purchase_id` varchar(22) DEFAULT NULL,
  `duty_id` varchar(55) DEFAULT NULL,
  `equipement_id` varchar(55) DEFAULT NULL,
  `qty` varchar(55) DEFAULT NULL,
  `price` varchar(55) DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `payment_method` varchar(20) DEFAULT NULL,
  `expensed_by` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `boucher_no` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `file_type` tinyint(4) NOT NULL,
  `folder_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `folders`
--

CREATE TABLE `folders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `user_id` tinyint(4) NOT NULL,
  `priority_order` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `inv_id` varchar(255) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `customer_id` varchar(25) NOT NULL,
  `additional_1` varchar(255) DEFAULT NULL,
  `additional_2` varchar(255) DEFAULT NULL,
  `total_item` float DEFAULT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `discount_amount` float DEFAULT NULL,
  `discount_percentage` varchar(55) DEFAULT NULL,
  `total_price` varchar(255) NOT NULL,
  `previous_due` varchar(55) DEFAULT NULL,
  `total_bill` varchar(55) DEFAULT NULL,
  `paid_amount` varchar(255) DEFAULT NULL,
  `due_amount` varchar(255) DEFAULT NULL,
  `payable_price` varchar(255) DEFAULT NULL,
  `profit` varchar(55) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `invoice_type` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `active` varchar(25) DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `invoice_date` varchar(100) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_sn` varchar(255) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `qty` float NOT NULL,
  `qty_box_pcs` varchar(255) DEFAULT NULL,
  `tp` varchar(55) DEFAULT NULL,
  `price` float NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `sub_total` float NOT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `profit_unit` varchar(55) DEFAULT NULL,
  `profit` varchar(55) DEFAULT NULL,
  `active` varchar(55) DEFAULT NULL,
  `created_at` varchar(55) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `parent` varchar(255) DEFAULT NULL,
  `category_id` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `link_action` varchar(255) DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `order_id` varchar(25) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `bank_id` varchar(255) DEFAULT NULL,
  `active` varchar(55) DEFAULT NULL,
  `customer_id` varchar(55) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productions`
--

CREATE TABLE `productions` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(25) NOT NULL,
  `raw_qty` varchar(255) DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vendor_id` varchar(255) DEFAULT NULL,
  `supplier_id` varchar(20) DEFAULT NULL,
  `total_item` varchar(255) DEFAULT NULL,
  `unit_qty` varchar(55) DEFAULT NULL,
  `qty` varchar(55) DEFAULT NULL,
  `total_qty` varchar(55) DEFAULT NULL,
  `transport_cost` varchar(55) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `dealer_name` varchar(255) DEFAULT NULL,
  `dealer_address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `production_details`
--

CREATE TABLE `production_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `production_id` varchar(20) DEFAULT NULL,
  `date` varchar(55) DEFAULT NULL,
  `product_id` varchar(255) NOT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `unit_qty` varchar(55) DEFAULT NULL,
  `courier` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `total_qty` varchar(255) DEFAULT NULL,
  `courier_pu` varchar(55) DEFAULT NULL,
  `price_c` varchar(55) DEFAULT NULL,
  `total_price_c` varchar(55) DEFAULT NULL,
  `product_sn` text DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `category_id` varchar(20) DEFAULT NULL,
  `sub_category_id` varchar(50) DEFAULT NULL,
  `tp` varchar(55) DEFAULT NULL,
  `price` float NOT NULL,
  `barcode` varchar(15) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `service_type` varchar(55) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `source_files` varchar(255) DEFAULT NULL,
  `file_formats` varchar(255) DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `msrp` float DEFAULT NULL,
  `style` varchar(255) DEFAULT NULL,
  `usages` varchar(255) DEFAULT NULL,
  `materials` varchar(255) DEFAULT NULL,
  `hidden_data` varchar(255) DEFAULT NULL,
  `brand` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `particular` varchar(255) DEFAULT NULL,
  `warranty` varchar(255) DEFAULT NULL,
  `measurement_unit` varchar(255) DEFAULT NULL,
  `featured` varchar(100) DEFAULT NULL,
  `is_set` varchar(55) DEFAULT NULL,
  `active` varchar(55) DEFAULT 'on',
  `hit_count` varchar(55) DEFAULT NULL,
  `created_by` varchar(55) NOT NULL,
  `updated_by` varchar(55) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `client_id`, `name`, `code`, `category_id`, `sub_category_id`, `tp`, `price`, `barcode`, `location`, `product_type`, `service_type`, `model`, `images`, `thumbnail`, `source_files`, `file_formats`, `slug`, `description`, `short_description`, `meta_description`, `msrp`, `style`, `usages`, `materials`, `hidden_data`, `brand`, `particular`, `warranty`, `measurement_unit`, `featured`, `is_set`, `active`, `hit_count`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Samsung M20', NULL, '1', NULL, '15000', 16000, NULL, NULL, 'Product', NULL, NULL, '', NULL, NULL, NULL, 'Samsung-M20', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'N/A', NULL, '10', NULL, NULL, NULL, 'on', NULL, '2', '', '2023-03-29 15:43:41', '2023-03-29 15:43:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `parent_id` int(255) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `active` varchar(55) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(55) DEFAULT NULL,
  `updated_by` varchar(55) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `name`, `slug`, `parent_id`, `image`, `description`, `active`, `client_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Mobile', 'Mobile', NULL, NULL, NULL, 'on', '1', '2', NULL, '2023-03-29 15:43:18', '2023-03-29 15:43:18');

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `product_id` varchar(111) NOT NULL,
  `store_id` varchar(111) DEFAULT NULL,
  `qty` varchar(55) NOT NULL,
  `type` varchar(55) DEFAULT NULL,
  `store_qty` varchar(255) DEFAULT NULL,
  `total_qty` varchar(255) DEFAULT NULL,
  `wet` varchar(55) DEFAULT NULL,
  `purchase_id` varchar(55) DEFAULT NULL,
  `invoice_id` varchar(55) DEFAULT NULL,
  `do_id` varchar(55) DEFAULT NULL,
  `do_status` varchar(55) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `created_by` varchar(55) DEFAULT NULL,
  `updated_by` varchar(55) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stock_details`
--

CREATE TABLE `product_stock_details` (
  `id` int(11) NOT NULL,
  `product_id` varchar(111) NOT NULL,
  `product_sn` varchar(111) DEFAULT NULL,
  `purchase_id` varchar(55) DEFAULT NULL,
  `invoice_id` varchar(55) DEFAULT NULL,
  `status` varchar(55) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(55) DEFAULT NULL,
  `updated_by` varchar(55) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `client_id` varchar(25) NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `company_id` varchar(255) DEFAULT NULL,
  `vendor_id` varchar(255) DEFAULT NULL,
  `supplier_id` varchar(20) DEFAULT NULL,
  `total_item` varchar(255) DEFAULT NULL,
  `total_qty` varchar(55) DEFAULT NULL,
  `transport_cost` varchar(55) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `dealer_name` varchar(255) DEFAULT NULL,
  `dealer_address` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `purchase_id` varchar(20) DEFAULT NULL,
  `product_id` varchar(255) NOT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `courier` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `courier_pu` varchar(55) DEFAULT NULL,
  `price_c` varchar(55) DEFAULT NULL,
  `total_price_c` varchar(55) DEFAULT NULL,
  `product_sn` text DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int(11) NOT NULL,
  `inv_id` varchar(255) DEFAULT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `customer_id` varchar(25) NOT NULL,
  `additional_1` varchar(255) DEFAULT NULL,
  `additional_2` varchar(255) DEFAULT NULL,
  `total_item` float DEFAULT NULL,
  `sub_total` varchar(255) DEFAULT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `discount_amount` float DEFAULT NULL,
  `discount_percentage` varchar(55) DEFAULT NULL,
  `total_price` varchar(255) NOT NULL,
  `previous_due` varchar(55) DEFAULT NULL,
  `total_bill` varchar(55) DEFAULT NULL,
  `paid_amount` varchar(255) DEFAULT NULL,
  `due_amount` varchar(255) DEFAULT NULL,
  `payable_price` varchar(255) DEFAULT NULL,
  `profit` varchar(55) DEFAULT NULL,
  `payment_id` varchar(255) DEFAULT NULL,
  `status` varchar(100) NOT NULL,
  `invoice_type` varchar(255) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `active` varchar(25) DEFAULT NULL,
  `created_by` varchar(100) NOT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `invoice_date` varchar(100) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_details`
--

CREATE TABLE `return_details` (
  `id` int(11) NOT NULL,
  `client_id` varchar(25) DEFAULT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` varchar(255) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_sn` varchar(255) DEFAULT NULL,
  `product_type` varchar(255) DEFAULT NULL,
  `qty` float NOT NULL,
  `qty_box_pcs` varchar(255) DEFAULT NULL,
  `tp` varchar(55) DEFAULT NULL,
  `price` float NOT NULL,
  `tax` varchar(255) DEFAULT NULL,
  `sub_total` float NOT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `profit_unit` varchar(55) DEFAULT NULL,
  `profit` varchar(55) DEFAULT NULL,
  `active` varchar(55) DEFAULT NULL,
  `created_at` varchar(55) NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` text DEFAULT NULL,
  `business_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `type_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `product_type` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `stock_condition` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `stock_deduction` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `logo_header` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `logo_footer` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `invoice_message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `product_serial` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `warranty` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `wholesale` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `favicon` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `meta_description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `phone` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `mobile` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `website` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `fb_link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `twitter_link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `linkedin_link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `instagram_link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `pinterest_link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `youtube_link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `additional_1_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `additional_2_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `payment_details` varchar(55) DEFAULT NULL,
  `customer_signature` varchar(55) DEFAULT NULL,
  `inv_logo_size` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `nav_logo_size` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `inv_title_size` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `inv_sub_title_size` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `inv_address_size` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `product_ob` varchar(22) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `customer_ob` varchar(22) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `company_ob` varchar(22) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `language` varchar(55) DEFAULT NULL,
  `active` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `updated_by` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `client_id`, `title`, `sub_title`, `business_type`, `type_description`, `product_type`, `stock_condition`, `stock_deduction`, `slug`, `logo_header`, `logo_footer`, `invoice_message`, `product_serial`, `warranty`, `wholesale`, `favicon`, `description`, `short_description`, `meta_description`, `email`, `phone`, `mobile`, `address`, `website`, `fb_link`, `twitter_link`, `linkedin_link`, `instagram_link`, `pinterest_link`, `youtube_link`, `additional_1_title`, `additional_2_title`, `payment_details`, `customer_signature`, `inv_logo_size`, `nav_logo_size`, `inv_title_size`, `inv_sub_title_size`, `inv_address_size`, `product_ob`, `customer_ob`, `company_ob`, `language`, `active`, `hit_count`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Sabuj Telecom', 'A trusted computer and mobile showroom', 'm', 'Mobile', 'Product', NULL, NULL, NULL, 'images/1zXMsMEhVR0aAUpiiRjG9QFRmvSeFBd8iplhwSxn.png', 'images/xmFiBxS0f7i0R7UJKMp9nA2krZCJCK37mbWJP5ab.png', NULL, NULL, 'yes', 'yes', 'images/oXI0dtvybFkCTatMZobXodyhSFuvFjBw65Ho1i1Q.png', NULL, NULL, NULL, 'ferdousmobile@gmail.com', NULL, '01756976640, 01721129798', 'Level# 1, Shop# 10, Bagherhat.', NULL, 'https://www.facebook.com/', 'https://www.Twitter.com/', 'https://www.Linkedin.com/', 'https://www.Instagram.com/', 'https://www.Pinterest.com/', 'https://www.Youtube.com/', 'Computer Type', 'Num of Service', 'yes', NULL, '100', '70', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'on', NULL, NULL, '2', NULL, '2023-01-11 01:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` varchar(55) DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `sub_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `store_type` varchar(255) DEFAULT NULL,
  `category_id` varchar(20) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `link_title` varchar(255) DEFAULT NULL,
  `link_action` varchar(255) DEFAULT NULL,
  `active` varchar(20) DEFAULT NULL,
  `hit_count` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `client_id`, `title`, `sub_title`, `slug`, `store_type`, `category_id`, `image`, `description`, `short_description`, `address`, `link_title`, `link_action`, `active`, `hit_count`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '1', 'Store', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT '''User''',
  `is_verified` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_pass_code` varchar(255) DEFAULT NULL,
  `verification_code` varchar(255) DEFAULT NULL,
  `wrong_login_attempt` varchar(50) DEFAULT NULL,
  `active` varchar(50) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_id`, `name`, `email`, `user_type`, `is_verified`, `image`, `address`, `city`, `state`, `country`, `mobile`, `email_verified_at`, `password`, `reset_pass_code`, `verification_code`, `wrong_login_attempt`, `active`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 1, 'Admin', 'sabuj_telecom', 'Admin', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$10$znvuJ9rJNJPzilDoMG.3Fut3o35Q9K08oBMADWGXBkdsXCHsoWgpq', NULL, 'f8620f9684a8bc0b15d577e4e7706e02ec716e33', '2', NULL, NULL, '2022-06-14 02:03:04', '2023-01-11 01:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `wish_lists`
--

CREATE TABLE `wish_lists` (
  `id` int(11) NOT NULL,
  `user_id` varchar(25) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `active` varchar(25) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_checks`
--
ALTER TABLE `bank_checks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_flows`
--
ALTER TABLE `cash_flows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_accounts`
--
ALTER TABLE `company_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `daily_cash`
--
ALTER TABLE `daily_cash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_lookups`
--
ALTER TABLE `data_lookups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `duties`
--
ALTER TABLE `duties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `folders`
--
ALTER TABLE `folders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productions`
--
ALTER TABLE `productions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production_details`
--
ALTER TABLE `production_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stock_details`
--
ALTER TABLE `product_stock_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_details`
--
ALTER TABLE `return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wish_lists`
--
ALTER TABLE `wish_lists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_checks`
--
ALTER TABLE `bank_checks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_flows`
--
ALTER TABLE `cash_flows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `company_accounts`
--
ALTER TABLE `company_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_accounts`
--
ALTER TABLE `customer_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `daily_cash`
--
ALTER TABLE `daily_cash`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lookups`
--
ALTER TABLE `data_lookups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `duties`
--
ALTER TABLE `duties`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `folders`
--
ALTER TABLE `folders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productions`
--
ALTER TABLE `productions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `production_details`
--
ALTER TABLE `production_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_stock_details`
--
ALTER TABLE `product_stock_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_details`
--
ALTER TABLE `return_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `wish_lists`
--
ALTER TABLE `wish_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
