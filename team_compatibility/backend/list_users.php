<?php
session_start();
require 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><title>All Users</title></head>
<body>
    <h2>Registered Users</h2>
    <table border="1">
        <tr><th>ID</th><th>Name</th><th>Personality</th><th>Project</th></tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?= $u['user_id'] ?></td>
            <td><?= htmlspecialchars($u['name']) ?></td>
            <td><?= htmlspecialchars($u['personality']) ?></td>
            <td><?= htmlspecialchars($u['project_preference']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
