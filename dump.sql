SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `admins`
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `logs`
-- ----------------------------
DROP TABLE IF EXISTS `logs`;
CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;

-- ----------------------------
--  Table structure for `employees`
-- ----------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `birthday` date NOT NULL,
  `ssn` varchar(30) NOT NULL,
  `current_employee` tinyint(1) unsigned NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `ssn` (`ssn`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `employees_phones`
-- ----------------------------
DROP TABLE IF EXISTS `employees_phones`;
CREATE TABLE `employees_phones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id_2` (`employee_id`,`phone`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `employees_phones_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `employees_translations`
-- ----------------------------
DROP TABLE IF EXISTS `employees_translations`;
CREATE TABLE `employees_translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `introduction` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id_2` (`employee_id`,`lang`),
  KEY `employee_id` (`employee_id`),
  CONSTRAINT `employees_translations_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `admins_logs`
-- ----------------------------
DROP TABLE IF EXISTS `admins_logs`;
CREATE TABLE `admins_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `model_type` varchar(30) NOT NULL,
  `model_id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `data` json NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `log_id` (`log_id`),
  KEY `admin_id` (`admin_id`),
  CONSTRAINT `admins_logs_ibfk_2` FOREIGN KEY (`log_id`) REFERENCES `logs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admins_logs_ibfk_3` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;


INSERT INTO admins (id, name, email) VALUES (1, "Rashad Aghayev", 'admin@example.com');

START TRANSACTION;
    INSERT INTO employees (id, name, email, birthday, ssn, current_employee) VALUES (10, "Jack Black", 'jack@example.com', '1990-05-19', '987-65-4321', 1);

    INSERT INTO employees_phones (employee_id, phone) VALUES (10, 994505551199);

    INSERT INTO employees_translations (employee_id, lang, introduction, experience, education)
        VALUES (10, 'EN', 'Employee intro 1 (en)', 'Employee Experience 1 (en)', 'Employee Edu 1 (en)');

    INSERT INTO employees_translations (employee_id, lang, introduction, experience, education)
        VALUES (10, 'ES', 'Employee intro 1 (es)', 'Employee Experience 1 (es)', 'Employee Edu 1 (es)');

    INSERT INTO employees_translations (employee_id, lang, introduction, experience, education)
        VALUES (10, 'FR', 'Employee intro 1 (fr)', 'Employee Experience 1 (fr)', 'Employee Edu 1 (fr)');
COMMIT;

START TRANSACTION;
    INSERT INTO employees (id, name, email, birthday, ssn, current_employee) VALUES (11, "John Doe", 'john@example.com', '1971-01-11', '123-45-6789', 0);

    INSERT INTO employees_phones (employee_id, phone) VALUES (11, 15129191919);

    INSERT INTO employees_translations (employee_id, lang, introduction, experience, education)
        VALUES (11, 'EN', 'Employee intro 2 (en)', 'Employee Experience 2 (en)', 'Employee Edu 2 (en)');

    INSERT INTO employees_translations (employee_id, lang, introduction, experience, education)
        VALUES (11, 'ES', 'Employee intro 2 (es)', 'Employee Experience 2 (es)', 'Employee Edu 2 (es)');

    INSERT INTO employees_translations (employee_id, lang, introduction, experience, education)
        VALUES (11, 'FR', 'Employee intro 2 (fr)', 'Employee Experience 2 (fr)', 'Employee Edu 2 (fr)');
COMMIT;

START TRANSACTION;
    INSERT INTO logs (id, title) VALUES (100, ":adminName added a new employee with name: :employeeName");

    INSERT INTO admins_logs (admin_id, model_type, model_id, log_id, `data`)
        VALUES (1, 'employee', 10, 100, '{"adminName":"Rashad Aghayev", "employeeName":"Jack Black"}');
COMMIT;

START TRANSACTION;
    INSERT INTO logs (id, title) VALUES (101, ":employeeName was edited by :adminName");

    INSERT INTO admins_logs (admin_id, model_type, model_id, log_id, `data`)
        VALUES (1, 'employee', 11, 101, '{"adminName":"Rashad Aghayev", "employeeName":"John Doe"}');
COMMIT;


