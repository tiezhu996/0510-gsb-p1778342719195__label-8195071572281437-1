CREATE TABLE IF NOT EXISTS `fa_console` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `content` text,
  `status` tinyint(1) DEFAULT 1,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fa_restaurant_income_expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('income','expense') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text,
  `restaurant_name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fa_accommodation_income_expense` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('income','expense') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text,
  `property_name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fa_daily_financial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('income','expense') DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text,
  `date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fa_employee_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_name` varchar(100) DEFAULT NULL,
  `department` varchar(50) DEFAULT NULL,
  `position` varchar(50) DEFAULT NULL,
  `base_salary` decimal(10,2) DEFAULT NULL,
  `bonus` decimal(10,2) DEFAULT 0.00,
  `deduction` decimal(10,2) DEFAULT 0.00,
  `total_salary` decimal(10,2) DEFAULT NULL,
  `month` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `fa_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL DEFAULT '',
  `nickname` varchar(50) DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `salt` varchar(100) DEFAULT '',
  `avatar` varchar(255) DEFAULT '',
  `email` varchar(100) DEFAULT '',
  `loginfailure` tinyint(1) DEFAULT 0,
  `logintime` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `updatetime` int(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT '',
  `status` enum('normal','hidden') DEFAULT 'normal',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `fa_admin` (`id`, `username`, `nickname`, `password`, `salt`, `avatar`, `email`, `loginfailure`, `logintime`, `createtime`, `updatetime`, `token`, `status`) VALUES
(1, 'admin', '超级管理员', '0f705093dc6d1b5701926aa6c99f19d6', '5d52', '', '', 0, NULL, 1531716238, NULL, '', 'normal');
