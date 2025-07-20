<?php
require_once 'admin_auth.php';
require 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['match_id'])) {
    $stmt = $pdo->prepare("DELETE FROM matches WHERE match_id = ?");
    $stmt->execute([$_POST['match_id']]);
    $message = "Match deleted successfully.";
}

$matches = $pdo->query("
    SELECT 
        m.match_id,
        u1.name AS user1_name,
        u2.name AS user2_name,
        m.compatibility_score
    FROM matches m
    JOIN users u1 ON m.user1_id = u1.user_id
    JOIN users u2 ON m.user2_id = u2.user_id
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><title>Delete Match</title></head>
<body>
    <h2>Delete Match</h2>

    <?php if ($message) echo "<p>$message</p>"; ?>

    <form method="POST" action="">
        <label>Select a match to delete:</label><br>
        <select name="match_id" required>
            <option value="">-- Choose Match --</option>
            <?php foreach ($matches as $m): ?>
                <option value="<?= $m['match_id']; ?>">
                    <?= htmlspecialchars($m['user1_name']) ?> &amp; <?= htmlspecialchars($m['user2_name']) ?> (Score: <?= $m['compatibility_score'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="Delete Match" onclick="return confirm('Are you sure you want to delete this match?');">
    </form>
</body>
</html>