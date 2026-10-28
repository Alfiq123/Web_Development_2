CREATE DATABASE IF NOT EXISTS guestbook
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE guestbook;

CREATE TABLE IF NOT EXISTS messages (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(50) NOT NULL,
    message    TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);