<?php
require_once 'admin_auth.php'; // 🔐 Enforce admin session
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['name'];
    $x_factor = $_POST['x_factor'];

    try {
        $stmt = $pdo->prepare("INSERT INTO roles (name, x_factor) VALUES (:name, :x_factor)");
        $stmt->execute([
            ':name' => $name,
            ':x_factor' => $x_factor
        ]);

        $lastId = $pdo->lastInsertId();
        $update = $pdo->prepare("REPLACE INTO last_ids (feature, last_id) VALUES ('add_project_role', ?)");
        $update->execute([$lastId]);

        echo "Role added successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>