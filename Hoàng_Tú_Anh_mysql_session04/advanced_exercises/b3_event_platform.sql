-- Create database if not exists
CREATE DATABASE IF NOT EXISTS event_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE event_db;

-- Remove table if it already exists
DROP TABLE IF EXISTS events;

-- =========================
-- Table: events
-- =========================
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(200) NOT NULL,
    location VARCHAR(200),

    -- Start and end time using DATETIME
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,

    -- Flexible metadata using JSON
    event_details JSON,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;