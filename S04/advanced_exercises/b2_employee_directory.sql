-- B2: Employee Directory
-- HR employee table with ENUM and salary precision

CREATE DATABASE IF NOT EXISTS company_db;
USE company_db;

CREATE TABLE employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(100) UNIQUE,
    department VARCHAR(100),
    role ENUM('intern', 'staff', 'manager', 'director') DEFAULT 'staff',
    salary DECIMAL(10,2) CHECK (salary >= 0),
    hired_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
