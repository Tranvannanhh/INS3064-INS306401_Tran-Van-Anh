-- B3: Event Platform
-- Events table using JSON for flexible metadata

CREATE DATABASE IF NOT EXISTS event_db;
USE event_db;

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    event_date DATETIME NOT NULL,
    location VARCHAR(255),
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
