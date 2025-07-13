<?php
require_once 'admin_auth.php';
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['post_id'], $_POST['action'])) {
    $post_id = $_POST['post_id'];
    $action = $_POST['action'];

    try {
        if ($action === 'Approve') {
            $stmt = $pdo->prepare("UPDATE posts SET is_approved = TRUE WHERE post_id = :post_id");
        } elseif ($action === 'Reject') {
            $stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = :post_id");
        } elseif ($action === 'Flag') {
            $stmt = $pdo->prepare("UPDATE posts SET is_flagged = TRUE WHERE post_id = :post_id");
        } else {
            header("Location: admin_posts.php");
            exit();
        }

        $stmt->execute([':post_id' => $post_id]);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

header("Location: admin_posts.php");
exit();
?>
