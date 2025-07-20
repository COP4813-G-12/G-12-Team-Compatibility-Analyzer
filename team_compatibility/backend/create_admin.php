<?php
require_once 'db.php';

$username = 'admin';
$password = 'admin123';
$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO admins (username, password_hash) VALUES (:username, :hash)");
    $stmt->execute([
        ':username' => $username,
        ':hash' => $hash
    ]);

    $lastId = $pdo->lastInsertId();
    $update = $pdo->prepare("REPLACE INTO last_ids (feature, last_id) VALUES ('create_admin', ?)");
    $update->execute([$lastId]);

    echo "Admin created successfully.";
} catch (PDOException $e) {
    echo "Error creating admin: " . $e->getMessage();
}
?>