-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for monolead
CREATE DATABASE IF NOT EXISTS `monolead` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `monolead`;


-- Dumping structure for table monolead.activity
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` varchar(50) NOT NULL DEFAULT '0',
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `comment` varchar(1000) DEFAULT '-',
  `progress` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `visible` set('Y','N') NOT NULL DEFAULT 'Y',
  `input_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_COMMENT_TASK_ID` (`task_id`),
  KEY `FK_COMMENT_USER_ID` (`user_id`),
  KEY `FK_COMMENT_STATUS_ID` (`status_id`),
  CONSTRAINT `FK_COMMENT_STATUS_ID` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `FK_COMMENT_TASK_ID` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  CONSTRAINT `FK_COMMENT_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- Dumping data for table monolead.activity: ~5 rows (approximately)
/*!40000 ALTER TABLE `activity` DISABLE KEYS */;
INSERT INTO `activity` (`id`, `task_id`, `user_id`, `comment`, `progress`, `status_id`, `visible`, `input_date`) VALUES
	(1, 'TS011', 'SR003', '<p style="text-align: left;"><ol><li>- There are something messing arround about the PHP latest patch that make the PDO\'s raw query always returning error when we trying to put object in their query parameter,so we just replace it with a snippet we found in github but we don\'t know how long it can stand.&nbsp;</li><li>&nbsp;- <u>There are something messing arround about the PHP latest patch that make the PDO\'s raw query always returning error when we trying to put object in their query parameter,so we just replace it with a snippet we found in github but </u>we don\'t know how long it can stand.&nbsp;</li><li>- <span style="color:rgb(0,0,255);">There are something messing arround about the PHP latest patch that make the PDO\'s raw query always returning error when we trying to put object in their query parame</span>ter,so we just replace it with a snippet we found in github but we don\'t know how long it can stand.&nbsp;</li><li>&nbsp;- There are something messing arround about the PHP la', 11, 2, 'Y', '2015-06-03 12:23:50'),
	(2, 'TS011', 'SR003', '- #09 Complete', 100, 5, 'Y', '2015-06-03 12:28:50'),
	(3, 'TS011', 'SR003', 'BUG found', 33, 3, 'Y', '2015-06-04 08:06:02'),
	(5, 'TS011', 'SR003', 'Some error again', 15, 3, 'Y', '2015-06-04 08:54:03'),
	(6, 'TS011', 'SR003', '<span style="color:rgb(0,0,255);">HALO <b style="color: rgb(0, 0, 255);">AP<span style="font-size: 20px; color: rgb(0, 0, 255);">A KABA</span>R</b> SEMUA</span>', 88, 7, 'Y', '2015-06-04 09:25:57'),
	(7, 'TS011', 'SR004', 'ok complete', 99, 5, 'Y', '2015-06-04 10:41:47');
/*!40000 ALTER TABLE `activity` ENABLE KEYS */;


-- Dumping structure for table monolead.config
CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(50) DEFAULT NULL,
  `maintenance_mode` enum('Yes','No') DEFAULT NULL,
  `additional_footer` varchar(200) DEFAULT NULL,
  `datetime_format` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COMMENT='Config Table';

-- Dumping data for table monolead.config: ~0 rows (approximately)
/*!40000 ALTER TABLE `config` DISABLE KEYS */;
INSERT INTO `config` (`id`, `site_name`, `maintenance_mode`, `additional_footer`, `datetime_format`) VALUES
	(1, 'MonoLead - Project Management System', 'No', ' Project Management System', 'd F Y H:i');
/*!40000 ALTER TABLE `config` ENABLE KEYS */;


-- Dumping structure for table monolead.project
CREATE TABLE IF NOT EXISTS `project` (
  `id` varchar(50) NOT NULL,
  `name` varchar(200) DEFAULT '-',
  `description` varchar(500) DEFAULT '-',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `created_by` varchar(50) NOT NULL,
  `input_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_PROJECT_STATUS_ID` (`status_id`),
  CONSTRAINT `FK_PROJECT_STATUS_ID` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table monolead.project: ~3 rows (approximately)
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` (`id`, `name`, `description`, `status_id`, `created_by`, `input_date`) VALUES
	('PR014', 'Human Resource Managament System', 'A simple web based human resource management system (HRMS)', 1, '', '2015-06-01 10:55:29'),
	('PR015', 'General Affair IS', 'Web based inventory system for General Affair department', 2, '', '2015-06-01 10:55:37'),
	('PR016', 'KJS Maker', 'Kartu Jakarta Sabar (Card) Maker - Only indonesian will know', 5, '', '2015-06-01 10:55:46');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;


-- Dumping structure for table monolead.runningnumber
CREATE TABLE IF NOT EXISTS `runningnumber` (
  `numbercode` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `format` varchar(50) NOT NULL,
  `lastnumber` int(11) NOT NULL,
  PRIMARY KEY (`numbercode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table monolead.runningnumber: ~4 rows (approximately)
/*!40000 ALTER TABLE `runningnumber` DISABLE KEYS */;
INSERT INTO `runningnumber` (`numbercode`, `prefix`, `format`, `lastnumber`) VALUES
	('PROJECT', 'PR', '000', 17),
	('TASK', 'TS', '000', 13),
	('TICKET', 'TC', '000', 5),
	('USER', 'SR', '000', 4);
/*!40000 ALTER TABLE `runningnumber` ENABLE KEYS */;


-- Dumping structure for table monolead.status
CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `type` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Dumping data for table monolead.status: ~7 rows (approximately)
/*!40000 ALTER TABLE `status` DISABLE KEYS */;
INSERT INTO `status` (`id`, `name`, `type`, `icon`) VALUES
	(1, 'Open', 'PROJECT', 'icon-open'),
	(2, 'Close', 'PROJECT', 'icon-close'),
	(3, 'Reopen', 'PROJECT', 'icon-reopen'),
	(4, 'Unknown', 'PROJECT', 'icon-unknown'),
	(5, 'Complete', 'PROJECT', 'icon-complete'),
	(6, 'Waiting Assesment', 'PROJECT', 'icon-waiting'),
	(7, 'Stuck', 'PROJECT', 'icon-stuck');
/*!40000 ALTER TABLE `status` ENABLE KEYS */;


-- Dumping structure for table monolead.task
CREATE TABLE IF NOT EXISTS `task` (
  `id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '-',
  `description` varchar(1000) DEFAULT '-',
  `project_id` varchar(50) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `progress` int(11) NOT NULL DEFAULT '0',
  `priority` enum('High','Medium','Low','Other') NOT NULL DEFAULT 'Medium',
  `input_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `start_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_date` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_TASK_STATUS_ID` (`status_id`),
  KEY `FK_TASK_PROJECT_ID` (`project_id`),
  KEY `FK_TASK_CREATED_BY` (`created_by`),
  CONSTRAINT `FK_TASK_CREATED_BY` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_TASK_PROJECT_ID` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  CONSTRAINT `FK_TASK_STATUS_ID` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table monolead.task: ~3 rows (approximately)
/*!40000 ALTER TABLE `task` DISABLE KEYS */;
INSERT INTO `task` (`id`, `name`, `description`, `project_id`, `status_id`, `progress`, `priority`, `input_date`, `start_date`, `end_date`, `created_by`) VALUES
	('TS005', 'Test Task', 'Testing', 'PR014', 1, 6, 'Medium', '2015-06-01 11:07:12', '2015-06-08 00:00:00', '2015-06-10 01:00:00', 'SR003'),
	('TS006', 'Making of web app and ios friendly', 'quick job', 'PR015', 1, 11, 'High', '2015-06-01 16:00:59', '2015-06-18 00:00:00', '2015-06-19 01:00:00', 'SR003'),
	('TS011', 'I am editing this', 'nothing', 'PR016', 5, 0, 'Low', '2015-06-03 10:47:50', '2015-06-14 00:00:00', '2015-06-15 12:00:00', 'SR003');
/*!40000 ALTER TABLE `task` ENABLE KEYS */;


-- Dumping structure for table monolead.tasker
CREATE TABLE IF NOT EXISTS `tasker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `task_id` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_TASKER_TASK_ID` (`task_id`),
  KEY `FK_TASKER_USER_ID` (`user_id`),
  CONSTRAINT `FK_TASKER_TASK_ID` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`),
  CONSTRAINT `FK_TASKER_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;

-- Dumping data for table monolead.tasker: ~7 rows (approximately)
/*!40000 ALTER TABLE `tasker` DISABLE KEYS */;
INSERT INTO `tasker` (`id`, `user_id`, `task_id`) VALUES
	(32, 'SR003', 'TS005'),
	(33, 'SR004', 'TS005'),
	(34, 'SR004', 'TS006'),
	(35, 'SR005', 'TS006'),
	(37, 'SR005', 'TS011'),
	(38, 'SR004', 'TS011'),
	(39, 'SR003', 'TS011');
/*!40000 ALTER TABLE `tasker` ENABLE KEYS */;


-- Dumping structure for table monolead.ticket
CREATE TABLE IF NOT EXISTS `ticket` (
  `id` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT '-',
  `description` varchar(500) DEFAULT '-',
  `sender` varchar(50) DEFAULT '-',
  `verified` enum('Y','N') DEFAULT 'N',
  `type` enum('Bug','Report','Mistakes','Request') NOT NULL DEFAULT 'Bug',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `project_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table monolead.ticket: ~0 rows (approximately)
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;


-- Dumping structure for table monolead.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` varchar(50) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `phone` varchar(70) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `other` varchar(500) DEFAULT NULL,
  `status` enum('Active','Nonactive') DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `profile_pic_url` varchar(200) NOT NULL DEFAULT 'images/profile_pic_url/none.JPG',
  `usergroup_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_G` (`usergroup_id`),
  CONSTRAINT `FK_G` FOREIGN KEY (`usergroup_id`) REFERENCES `usergroup` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='User Table';

-- Dumping data for table monolead.user: ~2 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `fullname`, `nickname`, `email`, `phone`, `address`, `other`, `status`, `password`, `profile_pic_url`, `usergroup_id`) VALUES
	('SR003', 'Agus Sigit Wisnubroto', 'the one', 'aswzen@gmail.com', '085761333122', 'Jl. Melati, Kebon Jeruk', 'None', 'Active', 'admin123', 'images/profile_pic_url/SR003.JPG', 1),
	('SR004', 'Djenuar Dwi Putra Dalapang', 'jeje', 'djenuar@gmail.com', '080000000000', '', '', 'Active', 'admin', 'images/profile_pic_url/SR004.jpg', 1),
	('SR005', 'Muhammad Rheza Fadillah', 'rheza', 'mrheza@yahoo.com', '080000000001', NULL, NULL, 'Active', 'admin', '', 3);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table monolead.usergroup
CREATE TABLE IF NOT EXISTS `usergroup` (
  `id` int(11) NOT NULL,
  `groupcode` varchar(50) DEFAULT NULL,
  `usergroup` varchar(50) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Group Table';

-- Dumping data for table monolead.usergroup: ~3 rows (approximately)
/*!40000 ALTER TABLE `usergroup` DISABLE KEYS */;
INSERT INTO `usergroup` (`id`, `groupcode`, `usergroup`, `badge`, `icon`) VALUES
	(1, 'ADM', 'Admin', 'ADMINISTRATOR', 'icon-admin'),
	(2, ' ', 'Manager', 'MANAGER', 'icon-manager'),
	(3, ' ', 'Programmer', 'PROGRAMMER', 'icon-developer');
/*!40000 ALTER TABLE `usergroup` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
