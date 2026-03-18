-- ============================================================
-- FINVESTMART DATABASE SCHEMA
-- MySQL / MariaDB Compatible
-- ============================================================
-- HOW TO USE:
-- 1. Log in to Hostinger hPanel
-- 2. Go to Databases > phpMyAdmin
-- 3. Select your database
-- 4. Click "Import" tab
-- 5. Upload this .sql file and click "Go"
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";

-- ============================================================
-- TABLE: users
-- ============================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name`     VARCHAR(100) NOT NULL,
  `last_name`      VARCHAR(100) NOT NULL,
  `email`          VARCHAR(255) NOT NULL,
  `phone`          VARCHAR(15) NOT NULL,
  `city`           VARCHAR(100) DEFAULT NULL,
  `password_hash`  VARCHAR(255) NOT NULL,
  `pan_number`     VARCHAR(10) DEFAULT NULL,
  `aadhaar_last4`  VARCHAR(4) DEFAULT NULL,
  `referral_code`  VARCHAR(20) DEFAULT NULL,
  `referred_by`    INT UNSIGNED DEFAULT NULL,
  `is_admin`       TINYINT(1) NOT NULL DEFAULT 0,
  `kyc_status`     ENUM('pending','submitted','verified','rejected') DEFAULT 'pending',
  `status`         ENUM('active','inactive','blocked') NOT NULL DEFAULT 'active',
  `remember_token` VARCHAR(100) DEFAULT NULL,
  `last_login`     DATETIME DEFAULT NULL,
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `referral_code` (`referral_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: bank_details
-- ============================================================
DROP TABLE IF EXISTS `bank_details`;
CREATE TABLE `bank_details` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        INT UNSIGNED NOT NULL,
  `account_name`   VARCHAR(200) NOT NULL,
  `bank_name`      VARCHAR(100) DEFAULT NULL,
  `account_number` VARCHAR(30) DEFAULT NULL,
  `ifsc_code`      VARCHAR(15) DEFAULT NULL,
  `upi_id`         VARCHAR(100) DEFAULT NULL,
  `is_verified`    TINYINT(1) NOT NULL DEFAULT 0,
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: products
-- ============================================================
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_key`     VARCHAR(50) NOT NULL,
  `name`            VARCHAR(200) NOT NULL,
  `category`        ENUM('insurance','loan','investment','demat','credit_card','other') NOT NULL,
  `description`     TEXT DEFAULT NULL,
  `partner_name`    VARCHAR(100) DEFAULT NULL,
  `partner_logo`    VARCHAR(255) DEFAULT NULL,
  `reward_amount`   DECIMAL(10,2) NOT NULL DEFAULT 0,
  `min_amount`      DECIMAL(15,2) DEFAULT NULL,
  `max_amount`      DECIMAL(15,2) DEFAULT NULL,
  `interest_rate`   VARCHAR(50) DEFAULT NULL,
  `processing_days` INT DEFAULT NULL,
  `is_active`       TINYINT(1) NOT NULL DEFAULT 1,
  `sort_order`      INT DEFAULT 0,
  `created_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_key` (`product_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: applications
-- ============================================================
DROP TABLE IF EXISTS `applications`;
CREATE TABLE `applications` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        INT UNSIGNED DEFAULT NULL,
  `product_type`   VARCHAR(50) NOT NULL,
  `applicant_name` VARCHAR(200) NOT NULL,
  `phone`          VARCHAR(15) NOT NULL,
  `email`          VARCHAR(255) DEFAULT NULL,
  `extra_data`     JSON DEFAULT NULL,
  `reward_amount`  DECIMAL(10,2) NOT NULL DEFAULT 0,
  `partner_ref_id` VARCHAR(100) DEFAULT NULL,
  `status`         ENUM('pending','processing','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `admin_notes`    TEXT DEFAULT NULL,
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `status` (`status`),
  KEY `product_type` (`product_type`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: rewards
-- ============================================================
DROP TABLE IF EXISTS `rewards`;
CREATE TABLE `rewards` (
  `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`         INT UNSIGNED DEFAULT NULL,
  `application_id`  INT UNSIGNED DEFAULT NULL,
  `product_type`    VARCHAR(50) NOT NULL,
  `amount`          DECIMAL(10,2) NOT NULL,
  `status`          ENUM('pending','eligible','claimed','paid','rejected') NOT NULL DEFAULT 'pending',
  `transaction_id`  VARCHAR(100) DEFAULT NULL,
  `claimed_at`      DATETIME DEFAULT NULL,
  `paid_at`         DATETIME DEFAULT NULL,
  `created_at`      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `application_id` (`application_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: payouts
-- ============================================================
DROP TABLE IF EXISTS `payouts`;
CREATE TABLE `payouts` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        INT UNSIGNED DEFAULT NULL,
  `reward_id`      INT UNSIGNED DEFAULT NULL,
  `amount`         DECIMAL(10,2) NOT NULL,
  `transaction_id` VARCHAR(100) DEFAULT NULL,
  `method`         ENUM('bank','upi','wallet') NOT NULL DEFAULT 'bank',
  `status`         ENUM('pending','processing','completed','failed') NOT NULL DEFAULT 'pending',
  `paid_at`        DATETIME DEFAULT NULL,
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- TABLE: admin_users
-- ============================================================
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(200) NOT NULL,
  `email`         VARCHAR(255) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role`          ENUM('super_admin','admin','manager') DEFAULT 'admin',
  `last_login`    DATETIME DEFAULT NULL,
  `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- SEED DATA: Products
-- ============================================================
INSERT INTO `products` (`product_key`, `name`, `category`, `partner_name`, `reward_amount`, `processing_days`, `sort_order`) VALUES
('insurance', 'Life & Health Insurance', 'insurance', 'Multiple Partners', 1500.00, 1, 1),
('personal_loan', 'Personal Loan', 'loan', 'Multiple Partners', 3000.00, 2, 2),
('home_loan', 'Home Loan', 'loan', 'Multiple Partners', 5000.00, 5, 3),
('business_loan', 'Business Loan', 'loan', 'Multiple Partners', 4000.00, 3, 4),
('demat', 'Demat Account', 'demat', 'Multiple Partners', 700.00, 1, 5),
('investments', 'Mutual Funds & SIP', 'investment', 'Multiple Partners', 1000.00, 1, 6),
('credit_card', 'Credit Card', 'credit_card', 'Multiple Partners', 2000.00, 7, 7);

-- ============================================================
-- SEED DATA: Admin User
-- Password: Admin@123 (change this immediately!)
-- ============================================================
INSERT INTO `admin_users` (`name`, `email`, `password_hash`, `role`) VALUES
('Super Admin', 'admin@finvestmart.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'super_admin');

-- ============================================================
-- SEED DATA: Sample Users (for testing)
-- Password for all: Test@1234
-- ============================================================
INSERT INTO `users` (`first_name`, `last_name`, `email`, `phone`, `city`, `password_hash`, `referral_code`, `status`) VALUES
('Rahul', 'Sharma', 'rahul@example.com', '9876543210', 'Bangalore', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'RAH1234', 'active'),
('Priya', 'Nair', 'priya@example.com', '9876543211', 'Chennai', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PRI5678', 'active');

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- END OF SCHEMA
-- ============================================================
