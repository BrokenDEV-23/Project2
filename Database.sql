CREATE DATABASE IF NOT EXISTS payroll_db;

USE payroll_db;

-- Table to store information about employees
CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role ENUM('boss', 'manager', 'worker') NOT NULL,
    hourly_rate DECIMAL(10, 2) NOT NULL,
    total_hours_worked DECIMAL(10, 2) DEFAULT 0,
    UNIQUE KEY unique_name_role (name, role) -- Ensures unique name-role combination
);

-- Table to store login credentials for employees
CREATE TABLE IF NOT EXISTS employee_login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);

-- Table to store payroll information
CREATE TABLE IF NOT EXISTS payroll (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id INT NOT NULL,
    pay_date DATE NOT NULL,
    total_hours_worked DECIMAL(10, 2) NOT NULL,
    total_pay DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE
);
