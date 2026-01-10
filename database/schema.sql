-- ============================================
-- Simple MVC Example - Database Schema
-- ============================================
-- This SQL file creates the books table for the MVC example
-- Run this file in your MySQL/MariaDB database
-- Create database (if it doesn't exist)
CREATE DATABASE IF NOT EXISTS library_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE library_db;
-- ============================================
-- Table: books
-- Stores book information
-- ============================================
CREATE TABLE IF NOT EXISTS books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255) NOT NULL,
  isbn VARCHAR(20) NOT NULL,
  publisher VARCHAR(100),
  publication_year INT,
  category VARCHAR(50),
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX idx_title (title),
  INDEX idx_author (author),
  INDEX idx_isbn (isbn)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;
-- ============================================
-- Sample Data for Testing
-- ============================================
INSERT INTO books (
    title,
    author,
    isbn,
    publisher,
    publication_year,
    category,
    description
  )
VALUES (
    'Introduction to PHP',
    'John Developer',
    '978-0-123456-78-9',
    'Tech Publishers',
    2023,
    'Programming',
    'A comprehensive guide to PHP programming for beginners.'
  ),
  (
    'Database Design Fundamentals',
    'Sarah Database',
    '978-0-234567-89-0',
    'Data Press',
    2022,
    'Database',
    'Learn the fundamentals of database design and SQL.'
  ),
  (
    'Web Development Basics',
    'Mike Web',
    '978-0-345678-90-1',
    'Web Publishers',
    2023,
    'Web Development',
    'Essential concepts for modern web development.'
  ),
  (
    'Learning MySQL',
    'Anna Query',
    '978-0-456789-01-2',
    'Database Books Inc',
    2021,
    'Database',
    'Master MySQL database management.'
  ),
  (
    'HTML & CSS Complete Guide',
    'Tom Frontend',
    '978-0-567890-12-3',
    'Frontend Press',
    2023,
    'Web Development',
    'Complete guide to HTML5 and CSS3.'
  );
-- ============================================
-- Notes for Students
-- ============================================
-- 1. Update the database credentials in config/config.php
-- 2. This is a simple example to demonstrate MVC pattern
-- 3. You can add more columns or tables as needed for your project
-- ============================================