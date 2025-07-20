<?php
require_once 'admin_auth.php';
require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.user_id");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

echo "<h2>Moderate Posts</h2>";
echo "<table border='1'>
<tr><th>ID</th><th>User</th><th>Category</th><th>Content</th><th>Approved</th><th>Flagged</th><th>Actions</th></tr>";

foreach ($posts as $row) {
    $approved = $row['is_approved'] ? 'Yes' : 'No';
    $flagged = $row['is_flagged'] ? 'Yes' : 'No';

    echo "<tr>
        <td>{$row['post_id']}</td>
        <td>{$row['name']}</td>
        <td>{$row['category']}</td>
        <td>{$row['content']}</td>
        <td>$approved</td>
        <td>$flagged</td>
        <td>
            <form method='POST' action='moderate_post.php' style='display:inline;'>
                <input type='hidden' name='post_id' value='{$row['post_id']}'>
                <input type='submit' name='action' value='Approve'>
                <input type='submit' name='action' value='Reject'>
                <input type='submit' name='action' value='Flag'>
            </form>
        </td>
    </tr>";
}
echo "</table>";
?>