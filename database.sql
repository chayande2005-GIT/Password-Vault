CREATE DATABASE vault;
USE vault;

-- Table for storing user details
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

select * from users;


-- Table for storing passwords
-- Each password entry is linked to a user
CREATE TABLE passwords (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    site_name VARCHAR(255) NOT NULL,
    site_url VARCHAR(255) NOT NULL,
    site_username VARCHAR(255) NOT NULL,
    site_password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

select * from passwords;

-- Column for storing mpin
-- Each mpin entry is linked to a user
ALTER TABLE users
ADD COLUMN mpin VARCHAR(255) DEFAULT NULL,
ADD COLUMN is_mpin_enabled BOOLEAN DEFAULT FALSE;


-- Table for storing pending registrations and logins
-- This is used for OTP verification before finalizing registration or login
CREATE TABLE pending_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    password VARCHAR(255),
    email_otp VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Table for storing pending logins
-- This is used for OTP verification before finalizing login
CREATE TABLE pending_logins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    email_otp VARCHAR(10),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);