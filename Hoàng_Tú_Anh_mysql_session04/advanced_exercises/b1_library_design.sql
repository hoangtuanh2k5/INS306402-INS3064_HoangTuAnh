-- Use an existing database or create one
CREATE DATABASE IF NOT EXISTS library_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE library_db;

-- =========================
-- Table: books
-- =========================
CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(150) NOT NULL,
    isbn VARCHAR(13) NOT NULL UNIQUE,   -- ISBN-13 stored as VARCHAR
    published_year YEAR,
    copies_available INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- =========================
-- Table: members
-- =========================
CREATE TABLE members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE,
    phone VARCHAR(20),   -- Phone stored as VARCHAR for international format
    membership_date DATE DEFAULT CURRENT_DATE
) ENGINE=InnoDB;


-- =========================
-- Table: borrow_records
-- =========================
CREATE TABLE borrow_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    member_id INT NOT NULL,
    borrow_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,

    CONSTRAINT fk_borrow_book
        FOREIGN KEY (book_id)
        REFERENCES books(id)
        ON DELETE CASCADE,

    CONSTRAINT fk_borrow_member
        FOREIGN KEY (member_id)
        REFERENCES members(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;