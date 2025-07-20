-- Create and use the database
CREATE DATABASE IF NOT EXISTS team_compatibility;
USE team_compatibility;

-- Users Table
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

-- Posts Table
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

-- Table to store assigned roles to users
CREATE TABLE IF NOT EXISTS user_assigned_roles (
    assignment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE
);

-- Insert test users
INSERT INTO users (name, personality, project_preference, is_active, created_at)
VALUES
('Alice', 'INTJ', 'AI Research', 1, '2025-07-01'),
('Bob', 'ENFP', 'Web Dev', 1, '2025-07-02'),
('Charlie', 'ISTP', 'Networking', 0, '2025-07-03'),
('Danielle', 'INTJ', 'Web Dev', 0, '2025-07-03');

-- Insert test roles
INSERT INTO roles (name, x_factor)
VALUES ('Frontend Dev', 10), ('Backend Dev', 8), ('Backend Dev', 6);

-- Insert test matches
INSERT INTO matches (user1_id, user2_id, compatibility_score)
VALUES (1, 2, 5), (2, 3, 4), (3, 4, 3);

-- Insert test posts
INSERT INTO posts (user_id, content, is_approved, is_flagged, created_at, category)
VALUES
(1, 'Looking for a frontend dev!', 1, 0, '2025-07-01', 'teaming'),
(2, 'Join my AI project!', 1, 0, '2025-07-02', 'ai'),
(3, 'Help needed with database!', 0, 1, '2025-07-03', 'support'),
(4, 'Looking for a backend dev!', 0, 1, '2025-07-03', 'teaming');

-- Insert/replace test last_ids
REPLACE INTO last_ids (feature, last_id)
VALUES
('register_user', 4),
('match_users', 3),
('add_post', 4),
('add_project_role', 3),
('assign_role', 4),
('create_admin', 0);

-- Insert test assignments
INSERT INTO user_assigned_roles (user_id, role_id)
VALUES
(1, 2),
(2, 1),
(3, 3),
(4, 1);