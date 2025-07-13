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
        echo "Role added successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
