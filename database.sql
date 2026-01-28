-- =====================================================
-- E-LAUNDRY MANAGEMENT SYSTEM DATABASE
-- PHP 8 + MySQL + AdminLTE
-- =====================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+07:00";

-- Database
CREATE DATABASE IF NOT EXISTS `elaundry` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `elaundry`;

-- =====================================================
-- TABEL USERS (Admin & Kasir)
-- =====================================================
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `role` ENUM('admin', 'kasir') NOT NULL DEFAULT 'kasir',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL CUSTOMERS (Pelanggan)
-- =====================================================
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `address` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL PACKAGES (Paket Laundry)
-- =====================================================
DROP TABLE IF EXISTS `packages`;
CREATE TABLE `packages` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `type` ENUM('kg', 'satuan') NOT NULL DEFAULT 'kg',
    `price` DECIMAL(12,2) NOT NULL,
    `description` TEXT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL PROMOS (Kode Promo/Diskon)
-- =====================================================
DROP TABLE IF EXISTS `promos`;
CREATE TABLE `promos` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `code` VARCHAR(50) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `discount_type` ENUM('percent', 'fixed') NOT NULL DEFAULT 'percent',
    `discount_value` DECIMAL(12,2) NOT NULL,
    `min_purchase` DECIMAL(12,2) DEFAULT 0,
    `max_discount` DECIMAL(12,2) NULL,
    `valid_from` DATE NOT NULL,
    `valid_until` DATE NOT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL TRANSACTIONS (Transaksi)
-- =====================================================
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `invoice_code` VARCHAR(50) NOT NULL,
    `customer_id` INT(11) UNSIGNED NOT NULL,
    `user_id` INT(11) UNSIGNED NOT NULL,
    `promo_id` INT(11) UNSIGNED NULL,
    `subtotal` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `discount` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `total` DECIMAL(12,2) NOT NULL DEFAULT 0,
    `status` ENUM('baru', 'dicuci', 'disetrika', 'siap_ambil', 'selesai') NOT NULL DEFAULT 'baru',
    `entry_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `estimated_date` DATETIME NOT NULL,
    `completed_date` DATETIME NULL,
    `notes` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `invoice_code` (`invoice_code`),
    KEY `customer_id` (`customer_id`),
    KEY `user_id` (`user_id`),
    KEY `promo_id` (`promo_id`),
    KEY `status` (`status`),
    CONSTRAINT `fk_transaction_customer` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_transaction_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT,
    CONSTRAINT `fk_transaction_promo` FOREIGN KEY (`promo_id`) REFERENCES `promos` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL TRANSACTION_ITEMS (Detail Transaksi)
-- =====================================================
DROP TABLE IF EXISTS `transaction_items`;
CREATE TABLE `transaction_items` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `transaction_id` INT(11) UNSIGNED NOT NULL,
    `package_id` INT(11) UNSIGNED NOT NULL,
    `quantity` DECIMAL(10,2) NOT NULL,
    `price` DECIMAL(12,2) NOT NULL,
    `subtotal` DECIMAL(12,2) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `transaction_id` (`transaction_id`),
    KEY `package_id` (`package_id`),
    CONSTRAINT `fk_item_transaction` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_item_package` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- TABEL SETTINGS (Pengaturan Aplikasi)
-- =====================================================
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
    `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    `key_name` VARCHAR(100) NOT NULL,
    `value` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `key_name` (`key_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- DATA AWAL (SEED DATA)
-- =====================================================

-- Default Admin User (password: admin123)
INSERT INTO `users` (`username`, `password`, `name`, `role`) VALUES
('admin', '$2y$10$9E9p3bHVpkvhTo1eXNfJiOKet9C7nbUysxBGDRbdV.bLCk4ewtwSC', 'Administrator', 'admin'),
('kasir1', '$2y$10$9E9p3bHVpkvhTo1eXNfJiOKet9C7nbUysxBGDRbdV.bLCk4ewtwSC', 'Kasir Utama', 'kasir');

-- Default Packages
INSERT INTO `packages` (`name`, `type`, `price`, `description`) VALUES
('Cuci Kering', 'kg', 7000.00, 'Laundry cuci dan keringkan saja'),
('Cuci Setrika', 'kg', 10000.00, 'Laundry cuci, keringkan, dan setrika'),
('Setrika Saja', 'kg', 5000.00, 'Setrika pakaian yang sudah bersih'),
('Cuci Komplit Express', 'kg', 15000.00, 'Layanan express selesai 1 hari'),
('Bed Cover Single', 'satuan', 25000.00, 'Cuci bed cover ukuran single'),
('Bed Cover Double', 'satuan', 35000.00, 'Cuci bed cover ukuran double'),
('Selimut', 'satuan', 20000.00, 'Cuci selimut'),
('Gordyn per Meter', 'satuan', 8000.00, 'Cuci gordyn per meter panjang'),
('Jas/Blazer', 'satuan', 15000.00, 'Dry clean jas atau blazer'),
('Boneka Kecil', 'satuan', 15000.00, 'Cuci boneka ukuran kecil'),
('Boneka Besar', 'satuan', 30000.00, 'Cuci boneka ukuran besar');

-- Default Promo
INSERT INTO `promos` (`code`, `name`, `discount_type`, `discount_value`, `min_purchase`, `valid_from`, `valid_until`) VALUES
('WELCOME10', 'Diskon Member Baru', 'percent', 10.00, 50000.00, '2026-01-01', '2026-12-31'),
('HEMAT5000', 'Potongan 5000', 'fixed', 5000.00, 30000.00, '2026-01-01', '2026-06-30');

-- Default Settings
INSERT INTO `settings` (`key_name`, `value`) VALUES
('app_name', 'Laundry Tunas Bangsa'),
('company_name', 'Laundry Tunas Bangsa'),
('company_address', 'Jl. Contoh No. 123, Kota'),
('company_phone', '08123456789'),
('estimation_days', '2');

-- Sample Customers
INSERT INTO `customers` (`name`, `phone`, `address`) VALUES
('Budi Santoso', '081234567890', 'Jl. Merdeka No. 10'),
('Ani Wijaya', '081234567891', 'Jl. Sudirman No. 25'),
('Citra Dewi', '081234567892', 'Jl. Gatot Subroto No. 5');

COMMIT;
