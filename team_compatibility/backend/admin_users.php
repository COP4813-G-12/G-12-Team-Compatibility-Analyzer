<?php
require_once 'admin_auth.php';
require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

echo "<h2>Manage Users</h2>";
echo "<table border='1'>
<tr><th>ID</th><th>Name</th><th>Personality</th><th>Project</th><th>Status</th><th>Actions</th></tr>";

foreach ($users as $row) {
    $is_active = isset($row['is_active']) ? $row['is_active'] : 0;
    $status = $is_active ? 'Active' : 'Inactive';
    $toggle = $is_active ? 'Deactivate' : 'Activate';

    echo "<tr>
        <td>{$row['user_id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['personality']}</td>
        <td>{$row['project_preference']}</td>
        <td>$status</td>
        <td>
            <form style='display:inline;' method='POST' action='toggle_user_status.php'>
                <input type='hidden' name='user_id' value='{$row['user_id']}'>
                <input type='submit' value='$toggle'>
            </form>
            <form style='display:inline;' method='POST' action='edit_user.php'>
                <input type='hidden' name='user_id' value='{$row['user_id']}'>
                <input type='submit' value='Edit'>
            </form>
            <form style='display:inline;' method='POST' action='delete_user.php' onsubmit='return confirm(\"Delete this user?\")'>
                <input type='hidden' name='user_id' value='{$row['user_id']}'>
                <input type='submit' value='Delete'>
            </form>
        </td>
    </tr>";
}
echo "</table>";
?>