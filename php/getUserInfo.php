<?php
session_start();
require_once "db_connect.php";   // make sure path is correct

header('Content-Type: application/json; charset=utf-8');

// Default response structure
$data = [
    'level'    => null,
    'username' => null,
    'id'       => null,
    'audio'    => null,
];

// Check if user is logged in
if (!isset($_SESSION['user']) || !is_object($_SESSION['user']) || empty($_SESSION['user']->id)) {
    $data['error'] = 'User not logged in or session invalid';
    echo json_encode($data);
    exit;
}
// $userId =   $_SESSION['user']->id;          
$userId = (int) $_SESSION['user']->id;          // force integer
$username = $_SESSION['user']->username ?? '';  // fallback

try {
    $stmt = $db->prepare("
        SELECT level, audio 
        FROM pointslevel 
        WHERE user_id = :id
        LIMIT 1
    ");

    $stmt->execute([':id' => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $data['level']    = $row['level'] ?? null;
        $data['audio']    = $row['audio'] ?? null;
    } else {
        // Optional: log or set default values
        $data['level'] = 'A';           // ← you can choose a default
        $data['audio'] = 50;            // ← example default
        // or leave as null if you prefer
    }

    // Always fill these from session
    $data['username'] = $username;
    $data['id']       = $userId;

} catch (PDOException $e) {
    // In production you might want to log this instead of exposing
    $data['error'] = 'Database error';
    // error_log("getUserInfo error: " . $e->getMessage());
}

echo json_encode($data);