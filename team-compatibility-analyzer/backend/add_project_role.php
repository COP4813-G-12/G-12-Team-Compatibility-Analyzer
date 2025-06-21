<?php
session_start();
require 'db.php';

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    die("Access denied.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $x_factor = $_POST['x_factor'];

    $stmt = $pdo->prepare("INSERT INTO roles (name, x_factor) VALUES (?, ?)");
    $stmt->execute([$name, $x_factor]);
    echo "Project role added successfully.";
}
?>
