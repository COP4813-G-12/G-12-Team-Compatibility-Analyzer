<?php
require_once 'admin_auth.php';
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
            <th>ID</th>
            <th>Name</th>
            <th>X-Factor</th>
        </tr>
        <?php foreach ($roles as $role): ?>
        <tr>
            <td><?= $role['role_id'] ?></td>
            <td><?= $role['name'] ?></td>
            <td><?= $role['x_factor'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>