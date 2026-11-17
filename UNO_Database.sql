-- DATABASE U.N.O (USE NOT OWN)
-- MySQL / MariaDB - phpMyAdmin / XAMPP
CREATE DATABASE IF NOT EXISTS uno CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE uno;

-- 1. Accounts: role admin or user; owner/renter are user activities
CREATE TABLE IF NOT EXISTS users (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 phone VARCHAR(25) NULL,
 profile_photo VARCHAR(255) NULL,
 role ENUM('admin','user') NOT NULL DEFAULT 'user',
 status ENUM('active','inactive','suspended') NOT NULL DEFAULT 'active',
 email_verified_at TIMESTAMP NULL,
 remember_token VARCHAR(100) NULL,
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Categories
CREATE TABLE IF NOT EXISTS categories (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL UNIQUE,
 description TEXT NULL,
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. Rental items
CREATE TABLE IF NOT EXISTS items (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 owner_id BIGINT UNSIGNED NOT NULL,
 category_id BIGINT UNSIGNED NOT NULL,
 name VARCHAR(150) NOT NULL,
 description TEXT NOT NULL,
 price_per_day DECIMAL(12,2) NOT NULL,
 `condition` ENUM('new','like_new','good','fair') NOT NULL DEFAULT 'good',
 location VARCHAR(255) NOT NULL,
 status ENUM('available','unavailable','hidden') NOT NULL DEFAULT 'available',
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_items_owner FOREIGN KEY (owner_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE RESTRICT,
 CONSTRAINT fk_items_category FOREIGN KEY (category_id) REFERENCES categories(id) ON UPDATE CASCADE ON DELETE RESTRICT,
 CONSTRAINT chk_items_price CHECK (price_per_day >= 0),
 INDEX idx_items_owner (owner_id),
 INDEX idx_items_category (category_id),
 INDEX idx_items_status (status)
) ENGINE=InnoDB;

-- 4. Multiple item photos
CREATE TABLE IF NOT EXISTS item_images (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 item_id BIGINT UNSIGNED NOT NULL,
 image_url VARCHAR(255) NOT NULL,
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_item_images_item FOREIGN KEY (item_id) REFERENCES items(id) ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX idx_item_images_item (item_id)
) ENGINE=InnoDB;

-- 5. Availability calendar
CREATE TABLE IF NOT EXISTS availability (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 item_id BIGINT UNSIGNED NOT NULL,
 start_date DATE NOT NULL,
 end_date DATE NOT NULL,
 status ENUM('available','booked','blocked') NOT NULL DEFAULT 'available',
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_availability_item FOREIGN KEY (item_id) REFERENCES items(id) ON UPDATE CASCADE ON DELETE CASCADE,
 CONSTRAINT chk_availability_dates CHECK (end_date >= start_date),
 INDEX idx_availability_item_dates (item_id, start_date, end_date)
) ENGINE=InnoDB;

-- 6. Rental bookings
CREATE TABLE IF NOT EXISTS bookings (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 item_id BIGINT UNSIGNED NOT NULL,
 renter_id BIGINT UNSIGNED NOT NULL,
 start_date DATE NOT NULL,
 end_date DATE NOT NULL,
 total_days INT UNSIGNED NOT NULL,
 total_price DECIMAL(12,2) NOT NULL,
 status ENUM('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
 notes TEXT NULL,
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_bookings_item FOREIGN KEY (item_id) REFERENCES items(id) ON UPDATE CASCADE ON DELETE RESTRICT,
 CONSTRAINT fk_bookings_renter FOREIGN KEY (renter_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE RESTRICT,
 CONSTRAINT chk_bookings_dates CHECK (end_date >= start_date),
 CONSTRAINT chk_bookings_total_days CHECK (total_days >= 1),
 CONSTRAINT chk_bookings_total_price CHECK (total_price >= 0),
 INDEX idx_bookings_item (item_id),
 INDEX idx_bookings_renter (renter_id),
 INDEX idx_bookings_status (status),
 INDEX idx_bookings_dates (start_date, end_date)
) ENGINE=InnoDB;

-- 7. Reviews
CREATE TABLE IF NOT EXISTS reviews (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 booking_id BIGINT UNSIGNED NOT NULL UNIQUE,
 item_id BIGINT UNSIGNED NOT NULL,
 user_id BIGINT UNSIGNED NOT NULL,
 rating TINYINT UNSIGNED NOT NULL,
 comment TEXT NULL,
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_reviews_booking FOREIGN KEY (booking_id) REFERENCES bookings(id) ON UPDATE CASCADE ON DELETE CASCADE,
 CONSTRAINT fk_reviews_item FOREIGN KEY (item_id) REFERENCES items(id) ON UPDATE CASCADE ON DELETE CASCADE,
 CONSTRAINT fk_reviews_user FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
 CONSTRAINT chk_reviews_rating CHECK (rating BETWEEN 1 AND 5),
 INDEX idx_reviews_item (item_id),
 INDEX idx_reviews_user (user_id)
) ENGINE=InnoDB;

-- 8. Favorites
CREATE TABLE IF NOT EXISTS favorites (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 item_id BIGINT UNSIGNED NOT NULL,
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_favorites_user FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
 CONSTRAINT fk_favorites_item FOREIGN KEY (item_id) REFERENCES items(id) ON UPDATE CASCADE ON DELETE CASCADE,
 CONSTRAINT uq_favorites_user_item UNIQUE (user_id, item_id),
 INDEX idx_favorites_item (item_id)
) ENGINE=InnoDB;

-- 9. Notifications
CREATE TABLE IF NOT EXISTS notifications (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 title VARCHAR(150) NOT NULL,
 message TEXT NOT NULL,
 type VARCHAR(50) NOT NULL DEFAULT 'general',
 is_read BOOLEAN NOT NULL DEFAULT FALSE,
 created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
 INDEX idx_notifications_user_read (user_id, is_read)
) ENGINE=InnoDB;

-- Initial categories
INSERT IGNORE INTO categories (name, description) VALUES
('Electronics','Perangkat elektronik dan aksesorinya'),
('Camping & Outdoor','Peralatan camping dan aktivitas luar ruangan'),
('Vehicles','Kendaraan untuk kebutuhan sementara'),
('Home & Living','Perlengkapan rumah tangga'),
('Tools & Equipment','Peralatan kerja dan perlengkapan lainnya'),
('Fashion & Accessories','Pakaian dan aksesori');

-- Security notes:
-- Generate password hashes in your app; never store plain-text passwords.
-- Create/promote an admin account through a trusted seeder or protected process.
