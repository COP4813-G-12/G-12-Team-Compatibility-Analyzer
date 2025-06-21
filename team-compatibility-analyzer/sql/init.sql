-- Create and use the database
CREATE DATABASE IF NOT EXISTS team_compatibility;
USE team_compatibility;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    personality VARCHAR(4) NOT NULL,
    project_preference VARCHAR(100) NOT NULL
);

-- Table: roles
CREATE TABLE IF NOT EXISTS roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    x_factor INT NOT NULL CHECK (x_factor BETWEEN 1 AND 16)
);

-- Table: matches
CREATE TABLE IF NOT EXISTS matches (
    match_id INT AUTO_INCREMENT PRIMARY KEY,
    user1_id INT NOT NULL,
    user2_id INT NOT NULL,
    compatibility_score INT NOT NULL CHECK (compatibility_score BETWEEN 1 AND 5),
    FOREIGN KEY (user1_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (user2_id) REFERENCES users(user_id) ON DELETE CASCADE
);
