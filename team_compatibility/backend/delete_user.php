<?php
require_once 'admin_auth.php';
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

header("Location: admin_users.php");
exit();
?>