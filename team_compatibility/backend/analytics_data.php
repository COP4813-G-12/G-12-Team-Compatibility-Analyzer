<?php
require_once 'db.php';
header('Content-Type: application/json');

// Gets date range from query parameters, defaults to arbitrary range
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] . ' 00:00:00' : '2020-01-01 00:00:00';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] . ' 23:59:59' : date('Y-m-d') . ' 23:59:59';

$date_params = [$start_date, $end_date];

// Gets user registration trends by date data
$user_trend_query = $pdo->prepare("
    SELECT DATE(created_at) as registration_date, COUNT(*) as user_count
    FROM users
    WHERE created_at BETWEEN ? AND ?
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at)
");
$user_trend_query->execute($date_params);
$user_trends = $user_trend_query->fetchAll(PDO::FETCH_ASSOC);

// Gets active vs inactive user counts data
$user_status_query = $pdo->query("
    SELECT is_active, COUNT(*) as count 
    FROM users 
    GROUP BY is_active
");
$status_results = $user_status_query->fetchAll(PDO::FETCH_KEY_PAIR);

$active_users = isset($status_results[1]) ? $status_results[1] : 0;
$inactive_users = isset($status_results[0]) ? $status_results[0] : 0;

// Gets total user count data
$total_users_query = $pdo->query("SELECT COUNT(*) FROM users");
$total_users = $total_users_query->fetchColumn();

// Gets post categories within date range data
$post_categories_query = $pdo->prepare("
    SELECT category, COUNT(*) as post_count
    FROM posts
    WHERE created_at BETWEEN ? AND ?
    GROUP BY category
    ORDER BY post_count DESC
");
$post_categories_query->execute($date_params);
$post_categories = $post_categories_query->fetchAll(PDO::FETCH_ASSOC);

// Gets total post count for the date range data
$total_posts_query = $pdo->prepare("
    SELECT COUNT(*) as total
    FROM posts
    WHERE created_at BETWEEN ? AND ?
");
$total_posts_query->execute($date_params);
$total_post_count = (int) $total_posts_query->fetchColumn();

// Gets user compatibility matches data
$matches_query = $pdo->query("
    SELECT u1.name AS user1, u2.name AS user2, m.compatibility_score
    FROM matches m
    JOIN users u1 ON m.user1_id = u1.user_id
    JOIN users u2 ON m.user2_id = u2.user_id
    ORDER BY m.compatibility_score DESC
");
$user_matches = $matches_query->fetchAll(PDO::FETCH_ASSOC);

// Gets personality type data
$personality_query = $pdo->query("
    SELECT personality, COUNT(*) as count 
    FROM users 
    WHERE personality IS NOT NULL
    GROUP BY personality
    ORDER BY count DESC, personality ASC
");
$personality_data = $personality_query->fetchAll(PDO::FETCH_ASSOC);

// Gets project preference data
$preference_query = $pdo->query("
    SELECT project_preference, COUNT(*) as count 
    FROM users 
    WHERE project_preference IS NOT NULL
    GROUP BY project_preference
    ORDER BY count DESC
");
$preference_data = $preference_query->fetchAll(PDO::FETCH_ASSOC);

// Gets role data
$role_query = $pdo->query("
    SELECT name as role_name, COUNT(*) as count
    FROM roles
    GROUP BY name
    ORDER BY count DESC
");
$role_data = $role_query->fetchAll(PDO::FETCH_ASSOC);

// Gets feature usage data
$feature_list = ['register_user', 'match_users', 'add_post', 'add_project_role', 'create_admin'];
$feature_usage_data = [];

$feature_query = $pdo->prepare("SELECT last_id FROM last_ids WHERE feature = ?");
foreach ($feature_list as $feature_name) {
    $feature_query->execute([$feature_name]);
    $usage_count = $feature_query->fetchColumn();
    $feature_usage_data[] = [
        'feature' => $feature_name, 
        'count' => $usage_count ? (int) $usage_count : 0
    ];
}

// Builds response array
$response_data = [
    'match_table' => $user_matches,
    'user_trends' => [
        'labels' => array_column($user_trends, 'registration_date'),
        'counts' => array_map('intval', array_column($user_trends, 'user_count'))
    ],
    'user_status' => [
        'active' => $active_users,
        'inactive' => $inactive_users
    ],
    'total_users' => (int) $total_users,
    'post_categories' => [
        'labels' => array_column($post_categories, 'category'),
        'counts' => array_map('intval', array_column($post_categories, 'post_count'))
    ],
    'total_post_count' => $total_post_count,
    'most_used_features' => $feature_usage_data,
    'personality_stats' => $personality_data,
    'preference_distribution' => [
        'labels' => array_column($preference_data, 'project_preference'),
        'counts' => array_map('intval', array_column($preference_data, 'count'))
    ],
    'role_distribution' => [
        'labels' => array_column($role_data, 'role_name'),
        'counts' => array_map('intval', array_column($role_data, 'count'))
    ]
];

// Returns JSON response
echo json_encode($response_data);
?>