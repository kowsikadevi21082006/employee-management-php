-- schema.sql: create database, table, and sample data for employee_mgmt
CREATE DATABASE IF NOT EXISTS `employee_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `employee_db`;

CREATE TABLE IF NOT EXISTS `employees` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL UNIQUE,
  `position` VARCHAR(80) NOT NULL,
  `salary` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `joined_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample rows
INSERT INTO `employees` (`name`, `email`, `position`, `salary`) VALUES
('Alice Johnson', 'alice.johnson@example.com', 'Software Engineer', 75000.00),
('Bruno Martins', 'bruno.martins@example.com', 'Product Manager', 85000.00),
('Chen Li', 'chen.li@example.com', 'QA Engineer', 62000.00),
('Diana Smith', 'diana.smith@example.com', 'HR Specialist', 54000.00),
('Ethan Brown', 'ethan.brown@example.com', 'UX Designer', 68000.00);
