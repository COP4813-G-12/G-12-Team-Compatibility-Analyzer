<?php
require_once 'admin_auth.php';
require 'db.php';

function getMBTICompatibilityScore($type1, $type2) {
    $type1 = strtoupper(trim($type1));
    $type2 = strtoupper(trim($type2));
    
    // Maps personality types to indices
    $typeIndex = [
        'INFP' => 0, 'ENFP' => 1, 'INFJ' => 2, 'ENFJ' => 3,
        'INTJ' => 4, 'ENTJ' => 5, 'INTP' => 6, 'ENTP' => 7,
        'ISFP' => 8, 'ESFP' => 9, 'ISTP' => 10, 'ESTP' => 11,
        'ISFJ' => 12, 'ESFJ' => 13, 'ISTJ' => 14, 'ESTJ' => 15
    ];
    
    // Compatibility matrix
    // 1 = Bad, 2 = Not great, 3 = One-sided, 4 = Good, 5 = Perfect
    $matrix = [
        // INFP ENFP INFJ ENFJ INTJ ENTJ INTP ENTP ISFP ESFP ISTP ESTP ISFJ ESFJ ISTJ ESTJ
        [4,4,4,5,4,5,4,4,1,1,1,1,1,1,1,1], // INFP
        [4,4,5,4,5,4,4,4,1,1,1,1,1,1,1,1], // ENFP
        [4,5,4,4,4,4,4,5,1,1,1,1,1,1,1,1], // INFJ
        [5,4,4,4,4,4,4,4,5,1,1,1,1,1,1,1], // ENFJ
        [4,5,4,4,4,4,4,5,3,3,3,3,2,2,2,2], // INTJ
        [5,4,4,4,4,4,5,4,3,3,3,3,3,3,3,3], // ENTJ
        [4,4,4,4,4,5,4,4,3,3,3,3,2,2,2,5], // INTP
        [4,4,5,4,5,4,4,4,3,3,3,3,2,2,2,2], // ENTP
        [1,1,1,5,3,3,3,3,2,2,2,2,3,5,3,5], // ISFP
        [1,1,1,1,3,3,3,3,2,2,2,2,5,3,5,3], // ESFP
        [1,1,1,1,3,3,3,3,2,2,2,2,3,5,3,5], // ISTP
        [1,1,1,1,3,3,3,3,2,2,2,2,5,3,5,3], // ESTP
        [1,1,1,1,2,3,2,2,3,5,3,5,4,4,4,4], // ISFJ
        [1,1,1,1,2,3,2,2,5,3,5,3,4,4,4,4], // ESFJ
        [1,1,1,1,2,3,2,2,3,5,3,5,4,4,4,4], // ISTJ
        [1,1,1,1,2,3,5,2,5,3,5,3,4,4,4,4]  // ESTJ
    ];
    
    $idx1 = $typeIndex[$type1] ?? null;
    $idx2 = $typeIndex[$type2] ?? null;
    
    if ($idx1 === null || $idx2 === null) {
        return 1;
    }
    
    return $matrix[$idx1][$idx2];
}

$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
$matches = [];

for ($i = 0; $i < count($users); $i++) {
    for ($j = $i + 1; $j < count($users); $j++) {
        $u1 = $users[$i];
        $u2 = $users[$j];
        
        $score = getMBTICompatibilityScore($u1['personality'], $u2['personality']);

        $stmt = $pdo->prepare("INSERT INTO matches (user1_id, user2_id, compatibility_score) VALUES (?, ?, ?)");
        $stmt->execute([$u1['user_id'], $u2['user_id'], $score]);

        $lastMatchId = $pdo->lastInsertId();
    }
}

if ($lastMatchId !== null) {
    $update = $pdo->prepare("REPLACE INTO last_ids (feature, last_id) VALUES ('match_users', ?)");
    $update->execute([$lastMatchId]);
}

echo "Matches generated.";
?>