<?php
session_start();
require 'db.php';

$roles = $pdo->query("SELECT * FROM roles")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><title>Project Roles</title></head>
<body>
    <h2>Project Roles</h2>
    <table border="1">
        <tr>
            <th>Role ID</th>
            <th>Role Name</th>
            <th>X-Factor</th>
        </tr>
        <?php foreach ($roles as $role): ?>
        <tr>
            <td><?= $role['role_id'] ?></td>
            <td><?= htmlspecialchars($role['name']) ?></td>
            <td><?= htmlspecialchars($role['x_factor']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>