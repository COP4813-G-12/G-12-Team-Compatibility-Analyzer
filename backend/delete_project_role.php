<?php
require_once 'admin_auth.php';
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_role'])) {
    $id = $_POST['delete_role'];
    $stmt = $pdo->prepare("DELETE FROM roles WHERE role_id = ?");
    $stmt->execute([$id]);
    $message = "Project Role deleted successfully.";
}

$roles = $pdo->query("SELECT role_id, name FROM roles")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Project Role</title>
</head>
<body>
    <h2>Delete Project Role</h2>

    <?php if ($message) echo "<p>$message</p>"; ?>

    <form method="POST" action="">
        <label>Select a project role to delete:</label><br>
        <select name="delete_role" required>
            <option value="">-- Choose Project Role --</option>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['role_id']; ?>">
                    <?php echo htmlspecialchars($role['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Delete Project Role" onclick="return confirm('Are you sure you want to delete this project role?');">
    </form>
</body>
</html>