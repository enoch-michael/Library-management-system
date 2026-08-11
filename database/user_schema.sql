-- ============================================
-- Users table — Authentication
-- Run this against the existing library_db
-- ============================================

USE library_db;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Seed one default admin account so you can log
-- in immediately. Username: admin  Password: admin123
--
-- IMPORTANT: this hash was generated with PHP's
-- password_hash('admin123', PASSWORD_DEFAULT).
-- Change this password after your first login, and
-- definitely before submitting/presenting the project.
-- ============================================
INSERT INTO users (username, email, password_hash, role)
VALUES (
    'admin',
    'admin@library.local',
    '$2b$10$Guc5blPUzYhoDPZeAPKVl.Xi1LOVV77BR5KiyHUhr2SyJxqyJqQ/.',
    'admin'
);