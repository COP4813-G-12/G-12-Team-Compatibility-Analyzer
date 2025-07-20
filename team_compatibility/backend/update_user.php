<?php
require_once 'admin_auth.php';
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $personality = $_POST['personality'];
    $project = $_POST['project'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET name = :name, personality = :personality, project_preference = :project WHERE user_id = :user_id");
        $stmt->execute([
            ':name' => $name,
            ':personality' => $personality,
            ':project' => $project,
            ':user_id' => $user_id
        ]);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}

header("Location: admin_users.php");
exit();
?>
