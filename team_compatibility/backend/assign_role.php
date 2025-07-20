<?php
require_once 'admin_auth.php';
require_once 'db.php';

$mbtiMap = [
    'ISTJ' => 1, 'ISFJ' => 2, 'INFJ' => 3, 'INTJ' => 4,
    'ISTP' => 5, 'ISFP' => 6, 'INFP' => 7, 'INTP' => 8,
    'ESTP' => 9, 'ESFP' => 10, 'ENFP' => 11, 'ENTP' => 12,
    'ESTJ' => 13, 'ESFJ' => 14, 'ENFJ' => 15, 'ENTJ' => 16
];

$message = "";
$suggestedRoles = [];
$selectedUserId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'], $_POST['role_id'])) {
        $user_id = $_POST['user_id'];
        $role_id = $_POST['role_id'];

        $stmt = $pdo->prepare("INSERT INTO user_assigned_roles (user_id, role_id) VALUES (?, ?)");
        if($stmt->execute([$user_id, $role_id])) {
            $updateFeature = $pdo->prepare("
                INSERT INTO last_ids (feature, last_id)
                VALUES ('assign_role', 1)
                ON DUPLICATE KEY UPDATE last_id = last_id + 1
            ");
            $updateFeature->execute();
            $message = "Role assigned successfully";
        } else {
            $message = "Error assigning role";
        }

    } elseif (isset($_POST['user_id'])) {
        $selectedUserId = $_POST['user_id'];

        $stmt = $pdo->prepare("SELECT personality FROM users WHERE user_id = ?");
        $stmt->execute([$selectedUserId]);
        $personality = $stmt->fetchColumn();

        if (!$personality || !isset($mbtiMap[$personality])) {
            $message = "Can't find personality type or it's not valid";
        } else {
            $x = $mbtiMap[$personality];
            $roleStmt = $pdo->prepare("SELECT role_id, name FROM roles WHERE x_factor = ?");
            $roleStmt->execute([$x]);
            $suggestedRoles = $roleStmt->fetchAll();
            if (empty($suggestedRoles)) {
                $message = "No matching roles found for $personality personality type";
            } else {
                $message = "Here are the suggested roles for $personality:";
            }
        }
    }
}

$userStmt = $pdo->query("SELECT user_id, name, personality FROM users ORDER BY name ASC");
$users = $userStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Role to User</title>
</head>
<body>
    <h2>Assign Role Based on Personality</h2>

    <form method="POST">
        <label for="user_id">Select User:</label>
        <select name="user_id" required>
            <option value="">-- Select User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['user_id'] ?>" <?= ($selectedUserId == $user['user_id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['personality']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Get Role Suggestions</button>
    </form>

    <?php if ($message): ?>
        <p><strong><?= $message ?></strong></p>
    <?php endif; ?>

    <?php if (!empty($suggestedRoles) && $selectedUserId): ?>
        <form method="POST">
            <input type="hidden" name="user_id" value="<?= $selectedUserId ?>">
            <label for="role_id">Pick a Role:</label>
            <select name="role_id" required>
                <?php foreach ($suggestedRoles as $role): ?>
                    <option value="<?= $role['role_id'] ?>"><?= htmlspecialchars($role['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Assign This Role</button>
        </form>
    <?php endif; ?>
</body>
</html>