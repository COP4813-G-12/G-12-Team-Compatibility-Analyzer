<?php
require 'db.php';

$query = "
SELECT 
    u1.name AS user1,
    u2.name AS user2,
    m.compatibility_score
FROM matches m
JOIN users u1 ON m.user1_id = u1.user_id
JOIN users u2 ON m.user2_id = u2.user_id
";

$matches = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head><title>Match Results</title></head>
<body>
    <h2>Compatibility Matches</h2>
    <table border="1">
        <tr><th>User 1</th><th>User 2</th><th>Score</th></tr>
        <?php foreach ($matches as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['user1']) ?></td>
            <td><?= htmlspecialchars($m['user2']) ?></td>
            <td><?= $m['compatibility_score'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
