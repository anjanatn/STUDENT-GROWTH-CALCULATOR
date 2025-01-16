-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 05:43 PM
-- Server version: 8.0.34
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_points`
--

CREATE TABLE `activity_points` (
  `reg_no` int NOT NULL,
  `name_student` varchar(45) NOT NULL,
  `matter` varchar(45) NOT NULL,
  `point` varchar(45) NOT NULL,
  `date` date NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `activity_points`
--

INSERT INTO `activity_points` (`reg_no`, `name_student`, `matter`, `point`, `date`, `id`) VALUES
(1, 'abay', '.hack', '20', '2024-03-05', 5),
(2, 'Abil', 'NPTL', '50', '2024-05-03', 6);

-- --------------------------------------------------------

--
-- Table structure for table `parent`
--

CREATE TABLE `parent` (
  `reg_num` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `occupation` varchar(45) DEFAULT NULL,
  `student_name` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `sem_one`
--

CREATE TABLE `sem_one` (
  `reg_no` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `chemistry` int NOT NULL,
  `physics` int NOT NULL,
  `maths` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sem_one`
--

INSERT INTO `sem_one` (`reg_no`, `name`, `chemistry`, `physics`, `maths`) VALUES
(1, 'abay', 11, 16, 20),
(2, 'Abil', 10, 30, 50),
(6, 'Adithyan M', 22, 20, 32);

-- --------------------------------------------------------

--
-- Table structure for table `sem_two`
--

CREATE TABLE `sem_two` (
  `reg_no` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `electronics` int NOT NULL,
  `electrical` int NOT NULL,
  `civil_mech` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sem_two`
--

INSERT INTO `sem_two` (`reg_no`, `name`, `electronics`, `electrical`, `civil_mech`) VALUES
(1, 'abay', 36, 40, 80),
(2, 'Abil', 60, 70, 80),
(6, 'Adithyan M', 23, 32, 35);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `reg_num` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `age` int DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `fathers_name` varchar(45) NOT NULL,
  `semester` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`reg_num`, `name`, `age`, `email`, `fathers_name`, `semester`, `password`) VALUES
(1, 'abay', NULL, 'abay@gmail.com', 'dad', '1', '123'),
(2, 'Abil', NULL, 'abil@gmail.com', 'dad', '1', '123'),
(3, 'Achu', NULL, 'achu@gmail.com', 'dad', '1', '123'),
(4, 'Aqulin', NULL, 'aqulin@gmail.com', 'dad', '1', '123'),
(5, 'Adithyadev', NULL, 'adithyadev@gmail.com', 'dad', '1', '123'),
(6, 'Adithyan M', NULL, 'adithyanpaloor97@gmail.com', 'Dasan M', '1', '123'),
(7, 'aghiya', NULL, 'aghiya@gmail.com', 'dad', '1', '123'),
(8, 'Aiswariya', NULL, 'aiswariya@gmail.com', 'dad', '1', '123');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` int NOT NULL,
  `name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `subject` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `name`, `email`, `subject`, `password`) VALUES
(1, 'kripa', 'kripa@gmail.com', 'FLA', '123'),
(2, 'anu', 'anu@gmail.com', 'DA', '123'),
(3, 'susan', 'susan@gmail.com', 'JAVA', '123'),
(4, 'azeem2', 'azeem@gmail.com', 'C', '123'),
(5, 'pappan', 'pappan@gmail.com', 'CIVIL', '123'),
(6, 'Adithyan M', 'adhi@gmail.com', 'physics', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_points`
--
ALTER TABLE `activity_points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reg_no_UNIQUE` (`reg_no`);

--
-- Indexes for table `parent`
--
ALTER TABLE `parent`
  ADD PRIMARY KEY (`reg_num`),
  ADD UNIQUE KEY `reg_num_UNIQUE` (`reg_num`),
  ADD UNIQUE KEY `password_UNIQUE` (`password`);

--
-- Indexes for table `sem_one`
--
ALTER TABLE `sem_one`
  ADD PRIMARY KEY (`reg_no`),
  ADD UNIQUE KEY `reg_no_UNIQUE` (`reg_no`),
  ADD UNIQUE KEY `chemistry_UNIQUE` (`chemistry`),
  ADD UNIQUE KEY `physics_UNIQUE` (`physics`);

--
-- Indexes for table `sem_two`
--
ALTER TABLE `sem_two`
  ADD PRIMARY KEY (`reg_no`),
  ADD UNIQUE KEY `reg_no_UNIQUE` (`reg_no`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`reg_num`),
  ADD UNIQUE KEY `reg_num_UNIQUE` (`reg_num`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD UNIQUE KEY `teacher_id_UNIQUE` (`teacher_id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_points`
--
ALTER TABLE `activity_points`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `teacher_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_points`
--
ALTER TABLE `activity_points`
  ADD CONSTRAINT `activity_points_reg_no` FOREIGN KEY (`reg_no`) REFERENCES `student` (`reg_num`);

--
-- Constraints for table `parent`
--
ALTER TABLE `parent`
  ADD CONSTRAINT `parent_reg_num` FOREIGN KEY (`reg_num`) REFERENCES `student` (`reg_num`);

--
-- Constraints for table `sem_one`
--
ALTER TABLE `sem_one`
  ADD CONSTRAINT `sem_one_reg_no` FOREIGN KEY (`reg_no`) REFERENCES `student` (`reg_num`);

--
-- Constraints for table `sem_two`
--
ALTER TABLE `sem_two`
  ADD CONSTRAINT `sem_two_reg_no` FOREIGN KEY (`reg_no`) REFERENCES `student` (`reg_num`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
