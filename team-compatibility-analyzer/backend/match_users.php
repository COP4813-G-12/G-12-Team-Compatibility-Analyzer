<?php
require 'db.php';

$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$matches = [];

for ($i = 0; $i < count($users); $i++) {
    for ($j = $i + 1; $j < count($users); $j++) {
        $u1 = $users[$i];
        $u2 = $users[$j];
        $score = rand(1, 5); // Placeholder for compatibility logic

        $stmt = $pdo->prepare("INSERT INTO matches (user1_id, user2_id, compatibility_score) VALUES (?, ?, ?)");
        $stmt->execute([$u1['user_id'], $u2['user_id'], $score]);
    }
}

echo "Matches generated.";
?>
