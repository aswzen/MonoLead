
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(50) DEFAULT NULL,
  `maintenance_mode` enum('Yes','No') DEFAULT NULL,
  `additional_footer` varchar(200) DEFAULT NULL,
  `datetime_format` varchar(50) DEFAULT NULL,
  `guest_register` enum('Yes','No') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Config Table';

CREATE TABLE `usergroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupcode` varchar(50) DEFAULT NULL,
  `usergroup` varchar(50) DEFAULT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Group Table';

CREATE TABLE `runningnumber` (
  `numbercode` varchar(50) NOT NULL,
  `prefix` varchar(50) NOT NULL,
  `format` varchar(50) NOT NULL,
  `lastnumber` int(11) NOT NULL,
  PRIMARY KEY (`numbercode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `runningnumber` (`numbercode`, `prefix`, `format`, `lastnumber`) VALUES
  ('PROJECT', 'PR', '000', 0),
  ('TASK', 'TS', '000', 0),
  ('TICKET', 'TC', '000', 0),
  ('USER', 'SR', '000', 1);

CREATE TABLE `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `type` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `status` (`id`, `name`, `type`, `icon`) VALUES
  (1, 'Open', 'PROJECT', 'icon-open'),
  (2, 'Close', 'PROJECT', 'icon-close'),
  (3, 'Reopen', 'PROJECT', 'icon-reopen'),
  (4, 'Unknown', 'PROJECT', 'icon-unknown'),
  (5, 'Complete', 'PROJECT', 'icon-complete'),
  (6, 'Waiting Assesment', 'PROJECT', 'icon-waiting'),
  (7, 'Stuck', 'PROJECT', 'icon-stuck');

CREATE TABLE `project` (
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

CREATE TABLE `user` (
  `id` varchar(50) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `phone` varchar(70) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `other` varchar(500) DEFAULT NULL,
  `status` enum('Active','Nonactive') DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `profile_pic_url` varchar(200) NOT NULL DEFAULT 'images/profile_pic_url/none.jpg',
  `usergroup_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_G` (`usergroup_id`),
  CONSTRAINT `FK_G` FOREIGN KEY (`usergroup_id`) REFERENCES `usergroup` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='User Table';

CREATE TABLE `task` (
  `id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL DEFAULT '-',
  `description` text,
  `project_id` varchar(50) NOT NULL DEFAULT '0',
  `status_id` int(11) NOT NULL DEFAULT '0',
  `progress` int(11) NOT NULL DEFAULT '0',
  `priority` enum('High','Medium','Low','Other') NOT NULL DEFAULT 'Medium',
  `input_date` datetime DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `update_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  PRIMARY KEY (`id`),
  KEY `FK_TASK_STATUS_ID` (`status_id`),
  KEY `FK_TASK_PROJECT_ID` (`project_id`),
  KEY `FK_TASK_CREATED_BY` (`user_id`),
  CONSTRAINT `FK_TASK_CREATED_BY` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_TASK_PROJECT_ID` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_TASK_STATUS_ID` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tasker` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `task_id` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_TASKER_TASK_ID` (`task_id`),
  KEY `FK_TASKER_USER_ID` (`user_id`),
  CONSTRAINT `FK_TASKER_TASK_ID` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_TASKER_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `activity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` varchar(50) NOT NULL DEFAULT '0',
  `user_id` varchar(50) NOT NULL DEFAULT '0',
  `comment` varchar(1000) DEFAULT '-',
  `progress` int(11) DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `visible` set('Y','N') NOT NULL DEFAULT 'Y',
  `input_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_COMMENT_TASK_ID` (`task_id`),
  KEY `FK_COMMENT_USER_ID` (`user_id`),
  KEY `FK_COMMENT_STATUS_ID` (`status_id`),
  CONSTRAINT `FK_COMMENT_STATUS_ID` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`),
  CONSTRAINT `FK_COMMENT_TASK_ID` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_COMMENT_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `ticket` (
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

INSERT INTO `usergroup` (`id`, `groupcode`, `usergroup`, `badge`, `icon`) VALUES
  (1, 'ADM', 'Admin', 'ADMINISTRATOR', 'icon-admin'),
  (2, 'MAN', 'Manager', 'MANAGER', 'icon-manager'),
  (3, 'PRO', 'Programmer', 'PROGRAMMER', 'icon-developer');
