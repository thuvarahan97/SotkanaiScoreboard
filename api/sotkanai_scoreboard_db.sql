-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2020 at 03:48 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sotkanai_scoreboard_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_competitions`
--

CREATE TABLE `tbl_competitions` (
  `competition_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `competition_name` varchar(255) NOT NULL,
  `district_id` int(5) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_competitions`
--

TRUNCATE TABLE `tbl_competitions`;
--
-- Dumping data for table `tbl_competitions`
--

INSERT INTO `tbl_competitions` (`competition_id`, `competition_name`, `district_id`) VALUES
(0000000001, 'Comp1', 00009),
(0000000017, 'Jaffna Competition', 00009);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_districts`
--

CREATE TABLE `tbl_districts` (
  `district_id` int(5) UNSIGNED ZEROFILL NOT NULL,
  `district_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_districts`
--

TRUNCATE TABLE `tbl_districts`;
--
-- Dumping data for table `tbl_districts`
--

INSERT INTO `tbl_districts` (`district_id`, `district_name`) VALUES
(00001, 'Ampara'),
(00002, 'Anuradhapura'),
(00003, 'Badulla'),
(00004, 'Batticaloa'),
(00005, 'Colombo'),
(00006, 'Galle'),
(00007, 'Gampaha'),
(00008, 'Hambantota'),
(00009, 'Jaffna'),
(00010, 'Kalutara'),
(00011, 'Kandy'),
(00012, 'Kegalle'),
(00013, 'Kilinochchi'),
(00014, 'Kurunegala'),
(00015, 'Mannar'),
(00016, 'Matale'),
(00017, 'Matara'),
(00018, 'Moneragala'),
(00019, 'Mullaitivu'),
(00020, 'Nuwara-Eliya'),
(00021, 'Polonnaruwa'),
(00022, 'Puttalam'),
(00023, 'Ratnapura'),
(00024, 'Trincomalee'),
(00025, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_judges`
--

CREATE TABLE `tbl_judges` (
  `judge_id` varchar(100) NOT NULL,
  `judge_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_judges`
--

TRUNCATE TABLE `tbl_judges`;
--
-- Dumping data for table `tbl_judges`
--

INSERT INTO `tbl_judges` (`judge_id`, `judge_name`) VALUES
('JFN20#1000', 'Thuvarahan'),
('TW09', 'Thuva');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rounds`
--

CREATE TABLE `tbl_rounds` (
  `round_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `competition_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `round_name` varchar(255) NOT NULL,
  `round_status` enum('0','1') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_rounds`
--

TRUNCATE TABLE `tbl_rounds`;
--
-- Dumping data for table `tbl_rounds`
--

INSERT INTO `tbl_rounds` (`round_id`, `competition_id`, `round_name`, `round_status`) VALUES
(0000000001, 0000000001, 'Round1', '0'),
(0000000002, 0000000001, 'Round2', '1'),
(0000000014, 0000000017, 'Day 2 Round', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rounds_judges`
--

CREATE TABLE `tbl_rounds_judges` (
  `round_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `judge_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_rounds_judges`
--

TRUNCATE TABLE `tbl_rounds_judges`;
--
-- Dumping data for table `tbl_rounds_judges`
--

INSERT INTO `tbl_rounds_judges` (`round_id`, `judge_id`) VALUES
(0000000002, 'JFN20#1000'),
(0000000002, 'TW09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rounds_schools`
--

CREATE TABLE `tbl_rounds_schools` (
  `round_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `school_id_1` int(10) UNSIGNED ZEROFILL NOT NULL,
  `school_id_2` int(10) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_rounds_schools`
--

TRUNCATE TABLE `tbl_rounds_schools`;
--
-- Dumping data for table `tbl_rounds_schools`
--

INSERT INTO `tbl_rounds_schools` (`round_id`, `school_id_1`, `school_id_2`) VALUES
(0000000001, 0000000001, 0000000001),
(0000000002, 0000000001, 0000000002);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schools`
--

CREATE TABLE `tbl_schools` (
  `school_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `school_name` varchar(255) NOT NULL,
  `district_id` int(5) UNSIGNED ZEROFILL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_schools`
--

TRUNCATE TABLE `tbl_schools`;
--
-- Dumping data for table `tbl_schools`
--

INSERT INTO `tbl_schools` (`school_id`, `school_name`, `district_id`) VALUES
(0000000001, 'Jaffna Hindu College', 00009),
(0000000002, 'Kokuvil Hindu College', 00009);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_school_overall_scores`
--

CREATE TABLE `tbl_school_overall_scores` (
  `school_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `round_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `judge_id` varchar(100) NOT NULL,
  `score_1` int(11) NOT NULL,
  `score_2` int(11) NOT NULL,
  `score_3` int(11) NOT NULL,
  `score_4` int(11) NOT NULL,
  `score_5` int(11) NOT NULL,
  `score_6` int(11) NOT NULL,
  `total_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_school_overall_scores`
--

TRUNCATE TABLE `tbl_school_overall_scores`;
--
-- Dumping data for table `tbl_school_overall_scores`
--

INSERT INTO `tbl_school_overall_scores` (`school_id`, `round_id`, `judge_id`, `score_1`, `score_2`, `score_3`, `score_4`, `score_5`, `score_6`, `total_score`) VALUES
(0000000001, 0000000002, 'JFN20#1000', 49, 25, 82, 0, 0, 0, 156),
(0000000001, 0000000002, 'TW09', 69, 21, 46, 0, 0, 0, 136),
(0000000002, 0000000002, 'TW09', 69, 74, 49, 0, 0, 0, 192);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `student_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `school_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `student_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_students`
--

TRUNCATE TABLE `tbl_students`;
--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`student_id`, `school_id`, `student_name`) VALUES
(0000000001, 0000000001, 'Thuvarahan'),
(0000000002, 0000000001, 'Rajinthan'),
(0000000003, 0000000002, 'Prakash'),
(0000000004, 0000000002, 'Vivek'),
(0000000005, 0000000001, 'Sinthujan'),
(0000000006, 0000000002, 'Sajeevan'),
(0000000007, 0000000001, 'Tharmeekan'),
(0000000008, 0000000002, 'Nirojithan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_scores`
--

CREATE TABLE `tbl_student_scores` (
  `student_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `round_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `judge_id` varchar(100) NOT NULL,
  `score_1` int(11) NOT NULL,
  `score_2` int(11) NOT NULL,
  `score_3` int(11) NOT NULL,
  `score_4` int(11) NOT NULL,
  `score_5` int(11) NOT NULL,
  `score_6` int(11) NOT NULL,
  `total_score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_student_scores`
--

TRUNCATE TABLE `tbl_student_scores`;
--
-- Dumping data for table `tbl_student_scores`
--

INSERT INTO `tbl_student_scores` (`student_id`, `round_id`, `judge_id`, `score_1`, `score_2`, `score_3`, `score_4`, `score_5`, `score_6`, `total_score`) VALUES
(0000000001, 0000000002, 'TW09', 44, 6, 4, 9, 7, 3, 73),
(0000000002, 0000000002, 'JFN20#1000', 80, 17, 46, 0, 0, 0, 143),
(0000000002, 0000000002, 'TW09', 28, 6, 9, 6, 5, 1, 55),
(0000000003, 0000000002, 'JFN20#1000', 41, 91, 45, 0, 0, 0, 177),
(0000000003, 0000000002, 'TW09', 48, 48, 62, 0, 0, 0, 158),
(0000000004, 0000000002, 'JFN20#1000', 37, 67, 75, 0, 0, 0, 179),
(0000000004, 0000000002, 'TW09', 54, 38, 49, 0, 0, 0, 141),
(0000000006, 0000000002, 'JFN20#1000', 40, 75, 15, 0, 0, 0, 130),
(0000000006, 0000000002, 'TW09', 50, 76, 25, 0, 0, 0, 151),
(0000000008, 0000000002, 'JFN20#1000', 80, 32, 67, 0, 0, 0, 179),
(0000000008, 0000000002, 'TW09', 79, 40, 64, 0, 0, 0, 183);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `date_registered` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Truncate table before insert `tbl_users`
--

TRUNCATE TABLE `tbl_users`;
--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_id`, `username`, `password`, `firstname`, `lastname`, `date_registered`) VALUES
(2, 'Thuvarahan', 'fca466c9d397e97cdbd1fda4413d1841', 'Thuvarahan', 'Sivaneswaran', '2020-04-18 13:07:16');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_current_round`
-- (See below for the actual view)
--
CREATE TABLE `view_current_round` (
`competition_id` int(11) unsigned
,`competition_name` varchar(255)
,`round_id` int(11) unsigned
,`round_name` varchar(255)
,`school_id` int(11) unsigned
,`school_name` varchar(255)
,`student_id` int(11) unsigned
,`student_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `view_current_round`
--
DROP TABLE IF EXISTS `view_current_round`;

CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_current_round`  AS  select `tbl_rounds`.`competition_id` AS `competition_id`,`tbl_competitions`.`competition_name` AS `competition_name`,`c`.`round_id` AS `round_id`,`tbl_rounds`.`round_name` AS `round_name`,`a`.`school_id` AS `school_id`,`b`.`school_name` AS `school_name`,`a`.`student_id` AS `student_id`,`a`.`student_name` AS `student_name` from ((((`tbl_students` `a` join `tbl_schools` `b` on((`a`.`school_id` = `b`.`school_id`))) join `tbl_rounds_schools` `c` on((`b`.`school_id` = `c`.`school_id_1`))) join `tbl_rounds` on((`c`.`round_id` = `tbl_rounds`.`round_id`))) join `tbl_competitions` on((`tbl_rounds`.`competition_id` = `tbl_competitions`.`competition_id`))) where (`tbl_rounds`.`round_status` = '1') union select `tbl_rounds`.`competition_id` AS `competition_id`,`tbl_competitions`.`competition_name` AS `competition_name`,`c`.`round_id` AS `round_id`,`tbl_rounds`.`round_name` AS `round_name`,`a`.`school_id` AS `school_id`,`b`.`school_name` AS `school_name`,`a`.`student_id` AS `student_id`,`a`.`student_name` AS `student_name` from ((((`tbl_students` `a` join `tbl_schools` `b` on((`a`.`school_id` = `b`.`school_id`))) join `tbl_rounds_schools` `c` on((`b`.`school_id` = `c`.`school_id_2`))) join `tbl_rounds` on((`c`.`round_id` = `tbl_rounds`.`round_id`))) join `tbl_competitions` on((`tbl_rounds`.`competition_id` = `tbl_competitions`.`competition_id`))) where (`tbl_rounds`.`round_status` = '1') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_competitions`
--
ALTER TABLE `tbl_competitions`
  ADD PRIMARY KEY (`competition_id`),
  ADD UNIQUE KEY `competition_name` (`competition_name`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `tbl_districts`
--
ALTER TABLE `tbl_districts`
  ADD PRIMARY KEY (`district_id`),
  ADD UNIQUE KEY `district_name` (`district_name`);

--
-- Indexes for table `tbl_judges`
--
ALTER TABLE `tbl_judges`
  ADD PRIMARY KEY (`judge_id`);

--
-- Indexes for table `tbl_rounds`
--
ALTER TABLE `tbl_rounds`
  ADD PRIMARY KEY (`round_id`),
  ADD UNIQUE KEY `round_name` (`round_name`),
  ADD KEY `competition_id` (`competition_id`) USING BTREE;

--
-- Indexes for table `tbl_rounds_judges`
--
ALTER TABLE `tbl_rounds_judges`
  ADD PRIMARY KEY (`round_id`,`judge_id`),
  ADD KEY `tbl_rounds_judges_ibfk_2` (`judge_id`);

--
-- Indexes for table `tbl_rounds_schools`
--
ALTER TABLE `tbl_rounds_schools`
  ADD PRIMARY KEY (`round_id`),
  ADD KEY `school_id_1` (`school_id_1`) USING BTREE,
  ADD KEY `school_id_2` (`school_id_2`) USING BTREE;

--
-- Indexes for table `tbl_schools`
--
ALTER TABLE `tbl_schools`
  ADD PRIMARY KEY (`school_id`),
  ADD UNIQUE KEY `school_name` (`school_name`),
  ADD KEY `district_id` (`district_id`);

--
-- Indexes for table `tbl_school_overall_scores`
--
ALTER TABLE `tbl_school_overall_scores`
  ADD PRIMARY KEY (`school_id`,`round_id`,`judge_id`),
  ADD KEY `round_id` (`round_id`),
  ADD KEY `judge_id` (`judge_id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `student_name` (`student_name`),
  ADD KEY `tbl_students_ibfk_1` (`school_id`);

--
-- Indexes for table `tbl_student_scores`
--
ALTER TABLE `tbl_student_scores`
  ADD PRIMARY KEY (`student_id`,`round_id`,`judge_id`),
  ADD KEY `tbl_student_scores_ibfk_1` (`round_id`),
  ADD KEY `tbl_student_scores_ibfk_3` (`judge_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_competitions`
--
ALTER TABLE `tbl_competitions`
  MODIFY `competition_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_districts`
--
ALTER TABLE `tbl_districts`
  MODIFY `district_id` int(5) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tbl_rounds`
--
ALTER TABLE `tbl_rounds`
  MODIFY `round_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_schools`
--
ALTER TABLE `tbl_schools`
  MODIFY `school_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `student_id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_competitions`
--
ALTER TABLE `tbl_competitions`
  ADD CONSTRAINT `tbl_competitions_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `tbl_districts` (`district_id`);

--
-- Constraints for table `tbl_rounds`
--
ALTER TABLE `tbl_rounds`
  ADD CONSTRAINT `tbl_rounds_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `tbl_competitions` (`competition_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_rounds_judges`
--
ALTER TABLE `tbl_rounds_judges`
  ADD CONSTRAINT `tbl_rounds_judges_ibfk_1` FOREIGN KEY (`round_id`) REFERENCES `tbl_rounds` (`round_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_rounds_judges_ibfk_2` FOREIGN KEY (`judge_id`) REFERENCES `tbl_judges` (`judge_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_rounds_schools`
--
ALTER TABLE `tbl_rounds_schools`
  ADD CONSTRAINT `tbl_rounds_schools_ibfk_1` FOREIGN KEY (`round_id`) REFERENCES `tbl_rounds` (`round_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_rounds_schools_ibfk_2` FOREIGN KEY (`school_id_2`) REFERENCES `tbl_schools` (`school_id`),
  ADD CONSTRAINT `tbl_rounds_schools_ibfk_3` FOREIGN KEY (`school_id_1`) REFERENCES `tbl_schools` (`school_id`);

--
-- Constraints for table `tbl_schools`
--
ALTER TABLE `tbl_schools`
  ADD CONSTRAINT `tbl_schools_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `tbl_districts` (`district_id`);

--
-- Constraints for table `tbl_school_overall_scores`
--
ALTER TABLE `tbl_school_overall_scores`
  ADD CONSTRAINT `tbl_school_overall_scores_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `tbl_schools` (`school_id`),
  ADD CONSTRAINT `tbl_school_overall_scores_ibfk_2` FOREIGN KEY (`round_id`) REFERENCES `tbl_rounds` (`round_id`),
  ADD CONSTRAINT `tbl_school_overall_scores_ibfk_3` FOREIGN KEY (`judge_id`) REFERENCES `tbl_judges` (`judge_id`);

--
-- Constraints for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD CONSTRAINT `tbl_students_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `tbl_schools` (`school_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_student_scores`
--
ALTER TABLE `tbl_student_scores`
  ADD CONSTRAINT `tbl_student_scores_ibfk_1` FOREIGN KEY (`round_id`) REFERENCES `tbl_rounds` (`round_id`),
  ADD CONSTRAINT `tbl_student_scores_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `tbl_students` (`student_id`),
  ADD CONSTRAINT `tbl_student_scores_ibfk_3` FOREIGN KEY (`judge_id`) REFERENCES `tbl_judges` (`judge_id`);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
