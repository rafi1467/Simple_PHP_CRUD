-- ============================================================
-- Simple PHP CRUD - Database Schema & Seed Data
-- Run this file in phpMyAdmin or via MySQL CLI:
-- mysql -u root -P 3306 < database/schema.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS simple_php_crud
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE simple_php_crud;

DROP TABLE IF EXISTS students;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    department VARCHAR(50) NOT NULL,
    cgpa DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed sample students for demonstration
INSERT INTO students (name, email, phone, department, cgpa) VALUES
('Alice Johnson', 'alice@example.com', '01711000001', 'CSE', 3.13),
('Bob Smith', 'bob@example.com', '01711000002', 'BBA', 3.50),
('David Backham', 'david@example.com', '01711000003', 'English', 3.75);
