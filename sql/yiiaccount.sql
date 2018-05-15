-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2017 at 01:02 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yiiaccount`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
  `id` bigint(18) NOT NULL,
  `tag_id` bigint(18) DEFAULT NULL,
  `entrytype_id` bigint(18) NOT NULL,
  `number` bigint(18) DEFAULT NULL,
  `date` varchar(22) COLLATE utf8_unicode_ci NOT NULL,
  `dr_total` decimal(25,2) NOT NULL DEFAULT '0.00',
  `cr_total` decimal(25,2) NOT NULL DEFAULT '0.00',
  `narration` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `entries`
--

INSERT INTO `entries` (`id`, `tag_id`, `entrytype_id`, `number`, `date`, `dr_total`, `cr_total`, `narration`) VALUES
(1, NULL, 4, NULL, '2074-04-06', '22.00', '22.00', ''),
(2, NULL, 4, NULL, '2017-04-01', '22.00', '22.00', ''),
(3, NULL, 4, NULL, '2017-04-02', '234.00', '234.00', ''),
(4, NULL, 4, NULL, '2017-04-03', '11.00', '11.00', ''),
(5, NULL, 4, NULL, '2017-04-06', '33.40', '33.40', 'f'),
(6, NULL, 4, NULL, '2017-04-06', '32.45', '32.45', ''),
(7, NULL, 4, NULL, '2017-04-06', '11.00', '11.00', ''),
(8, NULL, 4, NULL, '2017-04-17', '12.00', '12.00', ''),
(9, NULL, 4, NULL, '2017-04-19', '2000.00', '2000.00', ''),
(10, NULL, 4, NULL, '2017-04-19', '10000.00', '10000.00', ''),
(11, NULL, 4, NULL, '2017-04-19', '40000.00', '40000.00', ''),
(12, NULL, 4, NULL, '2017-04-19', '40000.00', '40000.00', ''),
(14, NULL, 4, NULL, '2017-03-01', '50000.00', '50000.00', ''),
(15, NULL, 4, NULL, '2074-04-20', '2999.00', '2999.00', ''),
(16, NULL, 4, NULL, '0000-00-00', '1.00', '1.00', ''),
(17, NULL, 4, NULL, '2074-03-88', '22.00', '22.00', ''),
(18, NULL, 4, NULL, '2074-02-11', '33.00', '33.00', ''),
(19, NULL, 4, NULL, '2074-03-22', '2.00', '2.00', ''),
(20, NULL, 4, NULL, '2074-04-04', '12.00', '12.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `entryitems`
--

CREATE TABLE `entryitems` (
  `id` bigint(18) NOT NULL,
  `entry_id` bigint(18) NOT NULL,
  `ledger_id` bigint(18) NOT NULL,
  `amount` decimal(25,2) NOT NULL DEFAULT '0.00',
  `dc` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `reconciliation_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `entryitems`
--

INSERT INTO `entryitems` (`id`, `entry_id`, `ledger_id`, `amount`, `dc`, `reconciliation_date`) VALUES
(1, 1, 3, '22.00', 'D', NULL),
(2, 1, 6, '22.00', 'C', NULL),
(3, 2, 6, '22.00', 'D', NULL),
(4, 2, 2, '22.00', 'C', NULL),
(5, 3, 6, '233.00', 'D', NULL),
(6, 3, 2, '1.00', 'D', NULL),
(7, 3, 1, '234.00', 'C', NULL),
(8, 4, 7, '11.00', 'D', NULL),
(9, 4, 2, '11.00', 'C', NULL),
(10, 5, 2, '33.40', 'D', NULL),
(11, 5, 2, '33.40', 'C', NULL),
(12, 6, 1, '32.45', 'D', NULL),
(13, 6, 3, '32.45', 'C', NULL),
(14, 7, 3, '11.00', 'D', NULL),
(15, 7, 1, '11.00', 'C', NULL),
(16, 8, 2, '12.00', 'D', NULL),
(17, 8, 6, '12.00', 'C', NULL),
(18, 9, 2, '2000.00', 'D', NULL),
(19, 9, 3, '2000.00', 'C', NULL),
(20, 10, 3, '10000.00', 'D', NULL),
(21, 10, 2, '10000.00', 'C', NULL),
(22, 11, 2, '40000.00', 'D', NULL),
(23, 11, 3, '40000.00', 'C', NULL),
(24, 12, 2, '40000.00', 'D', NULL),
(25, 12, 3, '40000.00', 'C', NULL),
(28, 14, 1, '1000000.00', 'D', NULL),
(29, 14, 3, '1000000.00', 'C', NULL),
(30, 15, 2, '2999.00', 'D', NULL),
(31, 15, 3, '2999.00', 'C', NULL),
(32, 16, 1, '1.00', 'D', NULL),
(33, 16, 2, '1.00', 'C', NULL),
(34, 17, 3, '22.00', 'D', NULL),
(35, 17, 3, '22.00', 'C', NULL),
(36, 18, 1, '33.00', 'D', NULL),
(37, 18, 3, '33.00', 'C', NULL),
(38, 19, 2, '2.00', 'D', NULL),
(39, 19, 2, '2.00', 'C', NULL),
(40, 20, 2, '12.00', 'D', NULL),
(41, 20, 3, '12.00', 'C', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `entrytypes`
--

CREATE TABLE `entrytypes` (
  `id` bigint(18) NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `base_type` int(2) NOT NULL DEFAULT '0',
  `numbering` int(2) NOT NULL DEFAULT '1',
  `prefix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `suffix` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zero_padding` int(2) NOT NULL DEFAULT '0',
  `restriction_bankcash` int(2) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `entrytypes`
--

INSERT INTO `entrytypes` (`id`, `label`, `name`, `description`, `base_type`, `numbering`, `prefix`, `suffix`, `zero_padding`, `restriction_bankcash`) VALUES
(1, 'receipt', 'Receipt', 'Received in Bank account or Cash account', 1, 1, '', '', 0, 2),
(2, 'payment', 'Payment', 'Payment made from Bank account or Cash account', 1, 1, '', '', 0, 3),
(3, 'contra', 'Contra', 'Transfer between Bank account and Cash account', 1, 1, '', '', 0, 4),
(4, 'journal', 'Journal', 'Transfer between Non Bank account and Cash account', 1, 1, '', '', 0, 5);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` bigint(18) NOT NULL,
  `parent_id` bigint(18) DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `affects_gross` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `parent_id`, `name`, `code`, `affects_gross`) VALUES
(1, NULL, 'Assets', NULL, 0),
(2, NULL, 'Liabilities and Owners Equity', NULL, 0),
(3, NULL, 'Incomes', NULL, 0),
(4, NULL, 'Expenses', NULL, 0),
(5, 1, 'Fixed Assets', NULL, 0),
(6, 1, 'Current Assets', NULL, 0),
(7, 1, 'Investments', NULL, 0),
(8, 2, 'Capital Account', NULL, 0),
(9, 2, 'Current Liabilities', NULL, 0),
(10, 2, 'Loans (Liabilities)', NULL, 0),
(11, 3, 'Direct Incomes', NULL, 1),
(12, 4, 'Direct Expenses', NULL, 1),
(13, 3, 'Indirect Incomes', NULL, 1),
(14, 4, 'Indirect Expenses', NULL, 1),
(15, 3, 'Sales', NULL, 1),
(16, 4, 'Purchases', NULL, 1),
(17, 12, 'Under ex', NULL, 1),
(21, 6, '23', NULL, 1),
(22, 11, 'Aff', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ledgers`
--

CREATE TABLE `ledgers` (
  `id` bigint(18) NOT NULL,
  `group_id` bigint(18) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `op_balance` decimal(25,2) NOT NULL DEFAULT '0.00',
  `op_balance_dc` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(2) NOT NULL DEFAULT '0',
  `reconciliation` int(1) NOT NULL DEFAULT '0',
  `notes` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ledgers`
--

INSERT INTO `ledgers` (`id`, `group_id`, `name`, `code`, `op_balance`, `op_balance_dc`, `type`, `reconciliation`, `notes`) VALUES
(1, 8, 'new led', NULL, '12.00', 'C', 0, 0, ''),
(2, 12, 'Bank A/C', NULL, '0.00', '', 0, 0, ''),
(3, 15, 'Nabil A/C', NULL, '12.00', '', 0, 0, ''),
(6, 12, 'sdf', NULL, '0.00', '', 0, 0, 'f'),
(7, 12, 'an', '12', '0.00', 'D', 0, 0, 'c');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint(18) NOT NULL,
  `date` datetime NOT NULL,
  `level` int(1) NOT NULL,
  `host_ip` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fy_start` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `fy_end` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `currency_symbol` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `currency_format` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `decimal_places` int(2) NOT NULL DEFAULT '2',
  `date_format` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `timezone` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `manage_inventory` int(1) NOT NULL DEFAULT '0',
  `account_locked` int(1) NOT NULL DEFAULT '0',
  `email_use_default` int(1) NOT NULL DEFAULT '0',
  `email_protocol` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `email_host` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_port` int(5) NOT NULL,
  `email_tls` int(1) NOT NULL DEFAULT '0',
  `email_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `print_paper_height` decimal(10,3) NOT NULL DEFAULT '0.000',
  `print_paper_width` decimal(10,3) NOT NULL DEFAULT '0.000',
  `print_margin_top` decimal(10,3) NOT NULL DEFAULT '0.000',
  `print_margin_bottom` decimal(10,3) NOT NULL DEFAULT '0.000',
  `print_margin_left` decimal(10,3) NOT NULL DEFAULT '0.000',
  `print_margin_right` decimal(10,3) NOT NULL DEFAULT '0.000',
  `print_orientation` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `print_page_format` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `database_version` int(10) NOT NULL,
  `settings` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `address`, `email`, `fy_start`, `fy_end`, `currency_symbol`, `currency_format`, `decimal_places`, `date_format`, `timezone`, `manage_inventory`, `account_locked`, `email_use_default`, `email_protocol`, `email_host`, `email_port`, `email_tls`, `email_username`, `email_password`, `email_from`, `print_paper_height`, `print_paper_width`, `print_margin_top`, `print_margin_bottom`, `print_margin_left`, `print_margin_right`, `print_orientation`, `print_page_format`, `database_version`, `settings`) VALUES
(1, 'Encraft', 'asd', 'asd2A@ASdc.om', '2074-03-01', '2075-02-30', '', 'none', 2, 'd-M-Y|dd-M-yy', 'UTC', 0, 0, 1, 'Smtp', '', 0, 0, '', '', '', '0.000', '0.000', '0.000', '0.000', '0.000', '0.000', 'P', 'H', 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` bigint(18) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` char(6) COLLATE utf8_unicode_ci NOT NULL,
  `background` char(6) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` enum('admin','reader','writer') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'reader',
  `status` smallint(6) NOT NULL DEFAULT '1',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'cip-DkXAGdeBy4h3aWSMcYyrS-RMW1GX', '$2y$13$vCuhWRNEkUX7Su5wiY1BzOruAUh9YcBVtQMLQujaU.IoiRp.Smoiu', NULL, 'admin@admin.com', 'admin', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `tag_id` (`tag_id`),
  ADD KEY `entrytype_id` (`entrytype_id`);

--
-- Indexes for table `entryitems`
--
ALTER TABLE `entryitems`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `entry_id` (`entry_id`),
  ADD KEY `ledger_id` (`ledger_id`);

--
-- Indexes for table `entrytypes`
--
ALTER TABLE `entrytypes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD UNIQUE KEY `label` (`label`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `id` (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `id` (`id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_id` (`id`),
  ADD UNIQUE KEY `title` (`title`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` bigint(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `entryitems`
--
ALTER TABLE `entryitems`
  MODIFY `id` bigint(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `entrytypes`
--
ALTER TABLE `entrytypes`
  MODIFY `id` bigint(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` bigint(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `ledgers`
--
ALTER TABLE `ledgers`
  MODIFY `id` bigint(18) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint(18) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(18) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `entries`
--
ALTER TABLE `entries`
  ADD CONSTRAINT `entries_fk_check_entrytype_id` FOREIGN KEY (`entrytype_id`) REFERENCES `entrytypes` (`id`),
  ADD CONSTRAINT `entries_fk_check_tag_id` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Constraints for table `entryitems`
--
ALTER TABLE `entryitems`
  ADD CONSTRAINT `entryitems_fk_check_entry_id` FOREIGN KEY (`entry_id`) REFERENCES `entries` (`id`),
  ADD CONSTRAINT `entryitems_fk_check_ledger_id` FOREIGN KEY (`ledger_id`) REFERENCES `ledgers` (`id`);

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_fk_check_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `ledgers`
--
ALTER TABLE `ledgers`
  ADD CONSTRAINT `ledgers_fk_check_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
