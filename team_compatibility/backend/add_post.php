<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'] ?? null;
    $content = $_POST['content'] ?? '';

    if ($user_id && $content) {
        try {
            $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, is_approved, is_flagged) VALUES (?, ?, 0, 0)");
            $stmt->execute([$user_id, $content]);
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
