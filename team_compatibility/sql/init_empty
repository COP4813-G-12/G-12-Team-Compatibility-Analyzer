-- Create and use the database
CREATE DATABASE IF NOT EXISTS team_compatibility;
USE team_compatibility;

-- Users Table (with created_at added)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    personality VARCHAR(4) NOT NULL,
    project_preference VARCHAR(100) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Roles Table
CREATE TABLE IF NOT EXISTS roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    x_factor INT NOT NULL CHECK (x_factor BETWEEN 1 AND 16)
);

-- Matches Table
CREATE TABLE IF NOT EXISTS matches (
    match_id INT AUTO_INCREMENT PRIMARY KEY,
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    compatibility_score INT NOT NULL CHECK (compatibility_score BETWEEN 1 AND 5),
    FOREIGN KEY (user1_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL
);

-- Posts Table (with created_at and category added)
CREATE TABLE IF NOT EXISTS posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    is_flagged BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    category VARCHAR(100) DEFAULT 'general',
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Table to store last inserted IDs
CREATE TABLE IF NOT EXISTS last_ids (
    feature VARCHAR(50) PRIMARY KEY,
    last_id INT NOT NULL
);

-- Triggers to update last_ids
DELIMITER $$

CREATE TRIGGER update_last_user AFTER INSERT ON users
FOR EACH ROW
BEGIN
    REPLACE INTO last_ids (feature, last_id) VALUES ('register_user', NEW.user_id);
END$$

CREATE TRIGGER update_last_match AFTER INSERT ON matches
FOR EACH ROW
BEGIN
    REPLACE INTO last_ids (feature, last_id) VALUES ('match_users', NEW.match_id);
END$$

CREATE TRIGGER update_last_post AFTER INSERT ON posts
FOR EACH ROW
BEGIN
    REPLACE INTO last_ids (feature, last_id) VALUES ('add_post', NEW.post_id);
END$$

CREATE TRIGGER update_last_role AFTER INSERT ON roles
FOR EACH ROW
BEGIN
    REPLACE INTO last_ids (feature, last_id) VALUES ('add_project_role', NEW.role_id);
END$$

CREATE TRIGGER update_last_admin AFTER INSERT ON admins
FOR EACH ROW
BEGIN
    REPLACE INTO last_ids (feature, last_id) VALUES ('create_admin', NEW.admin_id);
END$$

DELIMITER ;
