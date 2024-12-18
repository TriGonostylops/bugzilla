-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 01:04 PM
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
-- Database: `bugzilla`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_patches`
--

CREATE TABLE `accepted_patches` (
  `p_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accepted_patches`
--

INSERT INTO `accepted_patches` (`p_id`, `u_id`) VALUES
(50, 4),
(50, 5),
(51, 6),
(51, 10),
(51, 13),
(52, 5),
(52, 12),
(52, 13),
(53, 6),
(53, 10),
(55, 4),
(55, 12),
(56, 10),
(56, 12),
(56, 13),
(58, 13),
(59, 5),
(59, 6),
(59, 13),
(59, 14),
(60, 13),
(60, 14),
(61, 10),
(62, 4),
(64, 13),
(72, 13),
(72, 14),
(74, 13);

-- --------------------------------------------------------

--
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `b_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `system_requirements` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bugs`
--

INSERT INTO `bugs` (`b_id`, `u_id`, `description`, `system_requirements`, `date`, `title`) VALUES
(170, 11, 'Nem tudom mi a rossz', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWeb...', '2024-10-15 15:45:09', 'Test'),
(171, 1, 'Bug in login feature causing timeout.', 'Windows 10, 8GB RAM, Chrome', '2024-10-21 10:30:00', 'Login Timeout - Issue 1'),
(209, 1, 'Bug in login feature causing timeout.', 'Windows 10, 8GB RAM, Chrome', '2024-10-25 10:30:00', 'Login Timeout'),
(210, 2, 'Unexpected error when submitting the form.', 'Ubuntu 20.04, 16GB RAM, Firefox', '2024-10-15 14:20:00', 'Form Submission Error'),
(211, 3, 'Page not loading correctly after recent update.', 'macOS Big Sur, 8GB RAM, Safari', '2024-10-18 09:15:00', 'Page Load Issue'),
(212, 4, 'User is unable to reset the password using email.', 'Windows 7, 4GB RAM, Edge', '2024-10-22 12:45:00', 'Password Reset Failure'),
(213, 5, 'Database connection error when accessing reports.', 'Linux Mint, 12GB RAM, Firefox', '2024-10-10 16:30:00', 'Database Connection Error'),
(214, 6, 'App crashes when uploading a large file.', 'Windows 10, 16GB RAM, Chrome', '2024-10-05 11:00:00', 'File Upload Crash'),
(215, 8, 'Login page not responsive on mobile devices.', 'iPhone 12, iOS 15, Safari', '2024-10-19 17:50:00', 'Mobile Login Issue'),
(216, 9, 'Search function does not return accurate results.', 'Windows 10, 8GB RAM, Chrome', '2024-10-24 08:25:00', 'Search Results Error'),
(217, 10, 'Notification feature not working after update.', 'Linux Ubuntu, 4GB RAM, Firefox', '2024-10-25 18:00:00', 'Notification Failure'),
(218, 1, 'Bug in login feature causing timeout.', 'Windows 10, 8GB RAM, Chrome', '2024-10-15 10:30:00', 'Login Timeout - Issue 2'),
(219, 2, 'Unexpected error when submitting the form.', 'Ubuntu 20.04, 16GB RAM, Firefox', '2024-10-13 12:15:00', 'Form Submission Error'),
(220, 3, 'Page not loading correctly after recent update.', 'macOS Big Sur, 8GB RAM, Safari', '2024-10-12 14:25:00', 'Page Load Issue'),
(221, 4, 'User is unable to reset the password using email.', 'Windows 7, 4GB RAM, Edge', '2024-10-17 08:30:00', 'Password Reset Failure'),
(222, 5, 'Database connection error when accessing reports.', 'Linux Mint, 12GB RAM, Firefox', '2024-10-22 16:45:00', 'Database Connection Error'),
(223, 6, 'App crashes when uploading a large file.', 'Windows 10, 16GB RAM, Chrome', '2024-10-09 09:10:00', 'File Upload Crash'),
(224, 8, 'Incorrect pricing displayed in the cart.', 'macOS Monterey, 8GB RAM, Safari', '2024-10-14 13:55:00', 'Cart Pricing Error'),
(225, 9, 'Login page not responsive on mobile devices.', 'iPhone 12, iOS 15, Safari', '2024-10-16 11:20:00', 'Mobile Login Issue'),
(226, 10, 'Search function does not return accurate results.', 'Linux Ubuntu, 4GB RAM, Firefox', '2024-10-19 18:00:00', 'Search Results Error'),
(227, 11, 'Notification feature not working after update.', 'Windows 10, 8GB RAM, Chrome', '2024-10-08 07:30:00', 'Notification Failure'),
(228, 1, 'Bug in login feature causing timeout.', 'Ubuntu 20.04, 16GB RAM, Firefox', '2024-10-11 10:10:00', 'Login Timeout'),
(229, 2, 'Unexpected error when submitting the form.', 'Windows 7, 4GB RAM, Edge', '2024-10-27 09:45:00', 'Form Submission Error'),
(230, 3, 'Page not loading correctly after recent update.', 'macOS Big Sur, 8GB RAM, Safari', '2024-10-20 14:30:00', 'Page Load Issue'),
(231, 4, 'User is unable to reset the password using email.', 'Windows 7, 4GB RAM, Edge', '2024-10-23 10:00:00', 'Password Reset Failure'),
(232, 5, 'Database connection error when accessing reports.', 'Linux Mint, 12GB RAM, Firefox', '2024-08-09 19:00:00', 'Database Connection Error'),
(233, 6, 'App crashes when uploading a large file.', 'Windows 10, 16GB RAM, Chrome', '2024-08-11 17:15:00', 'File Upload Crash'),
(234, 8, 'Incorrect pricing displayed in the cart.', 'macOS Monterey, 8GB RAM, Safari', '2024-07-29 13:05:00', 'Cart Pricing Error'),
(235, 9, 'Login page not responsive on mobile devices.', 'iPhone 12, iOS 15, Safari', '2024-06-28 10:20:00', 'Mobile Login Issue'),
(236, 10, 'Search function does not return accurate results.', 'Linux Ubuntu, 4GB RAM, Firefox', '2024-07-14 11:50:00', 'Search Results Error'),
(237, 11, 'Notification feature not working after update.', 'Windows 10, 8GB RAM, Chrome', '2024-08-03 09:30:00', 'Notification Failure'),
(238, 2, 'Bug in login feature causing timeout.', 'Windows 10, 8GB RAM, Chrome', '2024-08-22 10:10:00', 'Login Timeout'),
(239, 3, 'Unexpected error when submitting the form.', 'Ubuntu 20.04, 16GB RAM, Firefox', '2024-06-30 11:20:00', 'Form Submission Error'),
(240, 4, 'Page not loading correctly after recent update.', 'macOS Big Sur, 8GB RAM, Safari', '2024-07-05 12:40:00', 'Page Load Issue'),
(241, 5, 'User is unable to reset the password using email.', 'Windows 7, 4GB RAM, Edge', '2024-06-02 13:25:00', 'Password Reset Failure'),
(242, 6, 'Database connection error when accessing reports.', 'Linux Mint, 12GB RAM, Firefox', '2024-07-30 14:15:00', 'Database Connection Error'),
(243, 8, 'App crashes when uploading a large file.', 'Windows 10, 16GB RAM, Chrome', '2024-07-13 15:00:00', 'File Upload Crash'),
(244, 9, 'Incorrect pricing displayed in the cart.', 'macOS Monterey, 8GB RAM, Safari', '2024-08-24 16:25:00', 'Cart Pricing Error'),
(245, 10, 'Login page not responsive on mobile devices.', 'iPhone 12, iOS 15, Safari', '2024-06-08 17:35:00', 'Mobile Login Issue'),
(246, 1, 'Search function does not return accurate results.', 'Linux Ubuntu, 4GB RAM, Firefox', '2024-07-12 18:00:00', 'Search Results Error'),
(247, 2, 'Notification feature not working after update.', 'Windows 10, 8GB RAM, Chrome', '2024-08-05 19:15:00', 'Notification Failure'),
(248, 3, 'Bug in login feature causing timeout.', 'Windows 10, 8GB RAM, Chrome', '2024-07-06 09:50:00', 'Login Timeout');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `bug_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `bug_id`, `message`, `date`, `u_id`) VALUES
(32, 210, 'whyyy :ccc', '2024-11-28 18:53:36', 14),
(33, 229, 'pls make it work c:', '2024-11-29 10:48:03', 2);

-- --------------------------------------------------------

--
-- Table structure for table `patches`
--

CREATE TABLE `patches` (
  `p_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  `message` varchar(255) NOT NULL,
  `u_id` int(11) NOT NULL,
  `bug_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patches`
--

INSERT INTO `patches` (`p_id`, `code`, `is_approved`, `date`, `message`, `u_id`, `bug_id`) VALUES
(50, 'if (error) { console.log(\"Login Timeout Error\"); }', 0, '2024-10-12 14:30:00', 'Fix for login timeout issue.', 0, 170),
(51, 'function validateForm() { if (!email) { alert(\"Email is required\"); } }', 1, '2024-10-13 09:45:00', 'Fix for missing form validation.', 2, 171),
(52, 'const timeoutError = () => { alert(\"Page Load Timeout\"); };', 1, '2024-10-20 11:15:00', 'Fix for page load timeout.', 4, 209),
(53, 'document.getElementById(\"submitBtn\").disabled = true;', 0, '2024-10-05 10:00:00', 'Disable submit button when form is incomplete.', 8, 210),
(54, 'const fetchData = async () => { await fetch(\"/data\"); }', 0, '2024-10-17 16:25:00', 'Fix for asynchronous data fetch issue.', 9, 211),
(55, 'const updateCart = () => { cart.total = calculateTotal(); }', 0, '2024-10-19 13:40:00', 'Fixed cart calculation issue.', 0, 212),
(56, 'let userLoggedIn = false; if (!userLoggedIn) { alert(\"Please log in\"); }', 1, '2024-10-07 12:30:00', 'Fix for user session detection.', 2, 213),
(57, 'const passwordReset = (email) => { return resetPassword(email); };', 0, '2024-10-02 17:10:00', 'Fix for password reset function.', 4, 214),
(58, 'let items = []; function addToCart(item) { items.push(item); }', 0, '2024-10-10 14:50:00', 'Fix for cart item addition functionality.', 8, 215),
(59, 'const showNotification = (message) => { alert(message); }', 1, '2024-10-22 18:15:00', 'Notification feature updated.', 9, 216),
(60, 'function handleFormSubmit() { if (!isValid) { alert(\"Form is not valid!\"); } }', 0, '2024-10-18 11:30:00', 'Fix for form validation error.', 2, 217),
(61, 'const addToFavorites = (id) => { favorites.push(id); }', 0, '2024-10-09 15:00:00', 'Fixed add-to-favorites feature.', 0, 218),
(62, 'let cartTotal = 0; function calculateTotal() { return cartTotal + 10; }', 0, '2024-10-14 13:20:00', 'Cart total calculation updated.', 4, 219),
(63, 'const toggleVisibility = () => { document.getElementById(\"content\").classList.toggle(\"hidden\"); };', 0, '2024-10-06 14:10:00', 'Fix for content visibility toggle.', 8, 220),
(64, 'function logout() { session.invalidate(); }', 0, '2024-10-01 09:00:00', 'Logout function fixed.', 9, 221),
(65, 'let loginError = false; if (loginError) { console.log(\"Login failed\"); }', 0, '2024-10-23 16:00:00', 'Login error handling updated.', 0, 222),
(66, 'function validateInputs() { if (!email || !password) { alert(\"Missing fields\"); } }', 0, '2024-10-16 11:45:00', 'Input validation added.', 2, 223),
(67, 'const removeItem = (id) => { items = items.filter(item => item.id !== id); }', 0, '2024-10-04 10:35:00', 'Item removal functionality fixed.', 4, 224),
(68, 'document.getElementById(\"saveBtn\").disabled = false;', 0, '2024-10-11 12:25:00', 'Save button enabled after validation.', 8, 225),
(69, 'const fetchData = async (url) => { await fetch(url).then(res => res.json()); }', 0, '2024-10-08 17:45:00', 'Data fetch functionality improved.', 9, 226),
(70, 'function submitForm() { if (!formValid) { alert(\"Form is invalid!\"); } }', 0, '2024-10-21 14:00:00', 'Form submit validation fixed.', 0, 227),
(71, 'const updatePassword = (user) => { user.password = \"newPassword\"; }', 0, '2024-10-25 13:30:00', 'Password update functionality fixed.', 2, 228),
(72, 'let pageTitle = \"Home\"; function updateTitle(title) { pageTitle = title; }', 0, '2024-10-12 10:00:00', 'Page title dynamically updated.', 4, 229),
(73, 'function getUserInfo(userId) { return fetch(`/users/${userId}`); }', 0, '2024-10-03 08:45:00', 'User info fetch functionality fixed.', 8, 230),
(74, 'const addToCart = (itemId) => { cart.push(itemId); }', 0, '2024-10-15 12:10:00', 'Add to cart functionality improved.', 9, 231),
(83, '<form action=#>\r\n</form>', 0, '2024-11-29 10:55:21', 'maybe the action is what folds up the system', 2, 229),
(84, 'sessionFix(){\r\n  ...\r\n}', 0, '2024-11-29 11:00:53', 'this method supposedly fixes the issue', 15, 171);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `r_id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`r_id`, `role`) VALUES
(1, 'admin'),
(2, 'developer'),
(3, 'tester'),
(4, 'reporter');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `r_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`r_id`, `u_id`) VALUES
(1, 0),
(1, 11),
(2, 0),
(2, 2),
(2, 4),
(2, 8),
(2, 9),
(2, 15),
(3, 4),
(3, 5),
(3, 6),
(3, 10),
(3, 12),
(3, 13),
(3, 14),
(4, 0),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 6),
(4, 8),
(4, 9),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `u_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `password`, `u_id`) VALUES
('minden', 'bigus@chungus.leaddaway', '$2y$10$ALzClpwdfRJ.P0UEamTE/OlUC3m8jEVFnfsBaZGzy1WBlu3I7N/BW', 1),
('divdev', 'dev@loper.aaa', '$2y$10$UQaGSwl/4P3balydQes5kuBLLtrkUmkn1tiM/Xrxwr1GDLpuVEWQe', 2),
('slumper', 'bounka@badabink.slung', '$2y$10$RJgncZSuRArL2/zTqNhw2.rMjztzIfo..R4NHrKIh/dbXDhe5.ayG', 3),
('bambusz', 'bada@bam.busz', '$2y$10$Bn7Vl8.KXFnnCwaiiSWhO.Ghzt1KH5siDVAaan2jfxlnLKaxGJFoS', 4),
('BigChungus', 'Legandary@chungus.big', '$2y$10$xKPYVjqKDXGptBESrKS/eeH7Q06Oe.ZfmMPozZfYmyaTdVt6glA7i', 5),
('kampuszkrampusz', 'k@k.notk', '$2y$10$T1hWdzLoeC06VDFL94W1HuvPVZI7T1Zv/dPuSNjbJn4h2fHFqkfZG', 6),
('Csimpusz', 'cs@cs.slitty', '$2y$10$6XKKS2.w/ABz1s2Jbpjqw.kVOecPKK10Q6XfqpjdwTOhJPX/aGBc6', 8),
('Szkubidú', 'szkibidi@toilet.a', '$2y$10$ctLpk.lxMQCNHaBzo5O50.PmAYf6UGajco2jRzVaxAK4mKqyPKzni', 9),
('HardCoded', 'Silly@Ahhh.Goofy', '$2y$10$80iQiatxTrInf0WZTNZn7ODd2tdsDfTBiFcP.RAVYW.VbBHFuF5J6', 10),
('admin', 'AA@bing.bong', '$2y$10$wWNo4I1BSLJdufF6uldGI.LdTz10kadIgc1B23MJf2h4UXJAnA3M.', 11),
('tester_priest', 'istenem@miert.com', '$2y$10$qfBzsKxGHWKfG.7QmdUkB.B1xbqbXaxThufNSko5cZSXNarrZUN/u', 12),
('ikszde', 'iksz@de.a', '$2y$10$jjL6dF1.nk2Op6jF9CTkgOlkaCt2kix7efjW6rwiJtYek816VnJ/C', 13),
('jajdeunom', 'jajajajaj@bajajajajj.ajjaja', '$2y$10$jA029uGbBJXv7zuz9vKVJuNS/RF3mo8jYxAzb4Eyy.w4yvuUEFNdq', 14),
('developer_man', 'abc@d.e', '$2y$10$tkraxftBgsctORTxu/GPWekHSPA00v2qpSzhF7BaNQ2hgytAT5Fgu', 15);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_patches`
--
ALTER TABLE `accepted_patches`
  ADD PRIMARY KEY (`p_id`,`u_id`),
  ADD KEY `fk_patch_u` (`u_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `fk_bugs_user` (`u_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `fk_comment` (`bug_id`),
  ADD KEY `megolom_magamat_koszi` (`u_id`);

--
-- Indexes for table `patches`
--
ALTER TABLE `patches`
  ADD PRIMARY KEY (`p_id`),
  ADD KEY `fk_patch` (`bug_id`),
  ADD KEY `u_id` (`u_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`r_id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`r_id`,`u_id`),
  ADD KEY `fk_ru_user` (`u_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `patches`
--
ALTER TABLE `patches`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accepted_patches`
--
ALTER TABLE `accepted_patches`
  ADD CONSTRAINT `fk_patch_p` FOREIGN KEY (`p_id`) REFERENCES `patches` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_patch_u` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bugs`
--
ALTER TABLE `bugs`
  ADD CONSTRAINT `fk_bugs_user` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `megolom_magamat_koszi` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patches`
--
ALTER TABLE `patches`
  ADD CONSTRAINT `fk_patch` FOREIGN KEY (`bug_id`) REFERENCES `bugs` (`b_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `fk_ru_user` FOREIGN KEY (`u_id`) REFERENCES `users` (`u_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_r` FOREIGN KEY (`r_id`) REFERENCES `roles` (`r_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
