<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $personality = $_POST['personality'];
    $project = $_POST['project'];

    $stmt = $pdo->prepare("INSERT INTO users (name, personality, project_preference) VALUES (?, ?, ?)");
    $stmt->execute([$name, $personality, $project]);
    echo "User registered successfully.";
}
?>
