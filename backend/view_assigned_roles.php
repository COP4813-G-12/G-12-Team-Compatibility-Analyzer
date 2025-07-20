<?php
require_once 'admin_auth.php';
require_once 'db.php';

$query = "
SELECT 
    u.user_id,
    u.name AS user_name,
    u.personality,
    r.name AS role_name
FROM user_assigned_roles a
JOIN users u ON a.user_id = u.user_id
JOIN roles r ON a.role_id = r.role_id
ORDER BY u.name ASC
";
$rows = $pdo->query($query)->fetchAll();
?>

<h2>Assigned Roles</h2>
<table border="1">
    <tr>
        <th>User ID</th>
        <th>User Name</th>
        <th>Personality Type</th>
        <th>Assigned Role</th>
    </tr>
    <?php foreach ($rows as $row): ?>
    <tr>
        <td><?= htmlspecialchars($row['user_id']) ?></td>
        <td><?= htmlspecialchars($row['user_name']) ?></td>
        <td><?= htmlspecialchars($row['personality']) ?></td>
        <td><?= htmlspecialchars($row['role_name']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>