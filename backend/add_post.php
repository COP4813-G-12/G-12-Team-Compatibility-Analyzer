<?php
require_once 'admin_auth.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $category = trim($_POST['category']) ?? 'general';
    $content = $_POST['content'] ?? '';

    if ($user_id && $category && $content) {
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, category, content, is_approved, is_flagged, created_at) VALUES (?, ?, ?, 0, 0, NOW())");
            $stmt->execute([$user_id, $category, $content]);

            $lastPostId = $pdo->lastInsertId();
            $update = $pdo->prepare("REPLACE INTO last_ids (feature, last_id) VALUES ('add_post', ?)");
            $update->execute([$lastPostId]);

            echo "Post submitted successfully.";
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Missing user ID or content.";
    }
} else {
    echo "Invalid request method.";
}<?php
require_once 'admin_auth.php';
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $category = trim($_POST['category']) ?? 'general';
    $content = $_POST['content'] ?? '';

    if ($user_id && $category && $content) {
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, category, content, is_approved, is_flagged, created_at) VALUES (?, ?, ?, 0, 0, NOW())");
            $stmt->execute([$user_id, $category, $content]);

            $lastPostId = $pdo->lastInsertId();
            $update = $pdo->prepare("REPLACE INTO last_ids (feature, last_id) VALUES ('add_post', ?)");
            $update->execute([$lastPostId]);

            echo "Post submitted successfully.";
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    } else {
        echo "Missing user ID or content.";
    }
} else {
    echo "Invalid request method.";
}