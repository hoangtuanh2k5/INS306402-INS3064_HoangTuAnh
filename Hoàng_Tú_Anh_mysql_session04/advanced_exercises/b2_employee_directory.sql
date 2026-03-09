-- Create database if not exists
CREATE DATABASE IF NOT EXISTS company_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE company_db;

-- Remove table if exists
DROP TABLE IF EXISTS employees;

-- =========================
-- Table: employees
-- =========================
CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE,
    
    -- Department as ENUM (predefined values)
    department ENUM('HR', 'Engineering', 'Marketing', 'Sales', 'Finance', 'Operations') NOT NULL,
    
    -- Hire date using DATE
    hire_date DATE NOT NULL,
    
    -- Salary using DECIMAL for financial precision
    salary DECIMAL(15,2) NOT NULL,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;