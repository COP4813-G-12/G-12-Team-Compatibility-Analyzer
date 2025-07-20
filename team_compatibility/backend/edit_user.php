<?php
require_once 'admin_auth.php';
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute([':user_id' => $user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>

<h2>Edit User</h2>
<form method="POST" action="update_user.php">
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['user_id']) ?>">
    Name: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>
    Personality: <input type="text" name="personality" value="<?= htmlspecialchars($user['personality']) ?>" required><br><br>
    Project: <input type="text" name="project" value="<?= htmlspecialchars($user['project_preference']) ?>" required><br><br>
    <input type="submit" value="Update User">
</form>