<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded admin login
    if ($username === "admin" && $password === "password123") {
        $_SESSION['user_id'] = 0;
        $_SESSION['is_admin'] = true;
        header("Location: ../frontend/admin_menu.html");
        exit;
    } else {
        echo "Invalid credentials.";
    }
}
?>
