<?php
require_once 'admin_auth.php';
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['assignment_id'])) {
    $stmt = $pdo->prepare("DELETE FROM user_assigned_roles WHERE assignment_id = ?");
    $stmt->execute([$_POST['assignment_id']]);
    $message = "Assigned Role deleted successfully.";
}

$assignments = $pdo->query("
    SELECT 
        a.assignment_id,
        u.name AS user_name,
        r.name AS role_name
    FROM user_assigned_roles a
    JOIN users u ON a.user_id = u.user_id
    JOIN roles r ON a.role_id = r.role_id
    ORDER BY a.assignment_id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><title>Delete Assigned Role</title></head>
<body>
    <h2>Delete Assigned Role</h2>

    <?php if ($message) echo "<p>$message</p>"; ?>

    <form method="POST" action="">
        <label>Select an assigned role to delete:</label><br>
        <select name="assignment_id" required>
            <option value="">-- Choose Assigned Role --</option>
            <?php foreach ($assignments as $a): ?>
                <option value="<?= $a['assignment_id']; ?>">
                    <?= htmlspecialchars($a['user_name']) ?> - <?= htmlspecialchars($a['role_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Delete Assigned Role" onclick="return confirm('Are you sure you want to delete this assigned role?');">
    </form>
</body>
</html>