<?php
session_start();
require '../db/db_connect.php';

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role === 'admin') {
    $stmt = $conn->prepare("SELECT q.id, q.subject, q.message, q.category, q.status, q.created_at, u.name 
                            FROM queries q 
                            JOIN users u ON q.user_id = u.id");
} else {
    // fetch only this user's queries
    $stmt = $conn->prepare("SELECT q.id, q.subject, q.message, q.category, q.status, q.created_at 
                            FROM queries q 
                            WHERE q.user_id = ?");
    $stmt->bind_param("i", $user_id);
}

$stmt->execute();
$result = $stmt->get_result();

$queries = [];

while ($row = $result->fetch_assoc()) {
    $query_id = $row['id'];

    // fetch replies for this query
    $res_stmt = $conn->prepare("SELECT message, created_at FROM responses WHERE query_id = ?");
    $res_stmt->bind_param("i", $query_id);
    $res_stmt->execute();
    $res_result = $res_stmt->get_result();

    $replies = [];
    while ($reply = $res_result->fetch_assoc()) {
        $replies[] = $reply;
    }

    $row['replies'] = $replies;
    $queries[] = $row;
}

echo json_encode($queries);
?>
