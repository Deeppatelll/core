-- PHP MVC Application v-1.0.0
-- Database: module
-- Run this SQL in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS `module`;
USE `module`;

-- 1. Products Table
CREATE TABLE IF NOT EXISTS `products` (
    `product_id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `quantity` INT DEFAULT 0,
    `price` DECIMAL(10,2) DEFAULT 0.00,
    `description` VARCHAR(500) DEFAULT NULL,
    `status` TINYINT(1) DEFAULT 1,
    `created_date` DATETIME DEFAULT NULL,
    `updated_date` DATETIME DEFAULT NULL
) ENGINE=InnoDB;

-- 2. Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
    `category_id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(500) DEFAULT NULL,
    `status` TINYINT(1) DEFAULT 1,
    `created_date` DATETIME DEFAULT NULL,
    `updated_date` DATETIME DEFAULT NULL
) ENGINE=InnoDB;

-- 3. Customers Table
CREATE TABLE IF NOT EXISTS `customers` (
    `customer_id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_group_id` INT DEFAULT NULL,
    `first_name` VARCHAR(255) NOT NULL,
    `last_name` VARCHAR(255) DEFAULT NULL,
    `email` VARCHAR(255) DEFAULT NULL,
    `phone` VARCHAR(20) DEFAULT NULL,
    `status` TINYINT(1) DEFAULT 1,
    `created_date` DATETIME DEFAULT NULL,
    `updated_date` DATETIME DEFAULT NULL
) ENGINE=InnoDB;

-- 4. Customer Groups Table
CREATE TABLE IF NOT EXISTS `customer_groups` (
    `customer_group_id` INT AUTO_INCREMENT PRIMARY KEY,
    `group_name` VARCHAR(255) NOT NULL,
    `description` VARCHAR(500) DEFAULT NULL,
    `status` TINYINT(1) DEFAULT 1,
    `created_date` DATETIME DEFAULT NULL,
    `updated_date` DATETIME DEFAULT NULL
) ENGINE=InnoDB;

-- 5. Product Media Table
CREATE TABLE IF NOT EXISTS `product_media` (
    `product_media_id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT DEFAULT NULL,
    `file_path` VARCHAR(500) DEFAULT NULL,
    `alt_text` VARCHAR(255) DEFAULT NULL,
    `sort_order` INT DEFAULT 0,
    `is_main` TINYINT(1) DEFAULT 0,
    `is_thumb` TINYINT(1) DEFAULT 0,
    `is_cart` TINYINT(1) DEFAULT 0,
    `created_date` DATETIME DEFAULT NULL,
    `updated_date` DATETIME DEFAULT NULL
) ENGINE=InnoDB;
