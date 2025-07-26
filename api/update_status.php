<?php
session_start();
require '../db/db_connect.php';

$message = "";
$type = ""; // success or error

// Validate session and role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $message = " Unauthorized access.";
    $type = "error";
} elseif (!isset($_POST['query_id'], $_POST['status']) || empty(trim($_POST['status']))) {
    $message = " Missing or invalid data.";
    $type = "error";
} else {
    $query_id = intval($_POST['query_id']);
    $status = trim($_POST['status']);

    // Optional: Validate query exists
    $check = $conn->prepare("SELECT id FROM queries WHERE id = ?");
    $check->bind_param("i", $query_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $message = "❌ Query not found.";
        $type = "error";
    } else {
        // Update status
        $stmt = $conn->prepare("UPDATE queries SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $query_id);

        if ($stmt->execute()) {
            $message = "Query status updated to <b>$status</b>.";
            $type = "success";
        } else {
            $message = " Could not update status. Try again.";
            $type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Status Update</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(-45deg, #636fa4, #e8cbc0, #89f7fe, #66a6ff);
      background-size: 400% 400%;
      animation: gradient 12s ease infinite;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    @keyframes gradient {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .card {
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(12px);
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
      text-align: center;
      animation: slideIn 0.8s ease-out;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateY(40px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .message {
      font-size: 22px;
      color: <?= $type === "success" ? "#2ecc71" : "#e74c3c" ?>;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .back-btn {
      text-decoration: none;
      color: white;
      padding: 10px 20px;
      border: 2px solid white;
      border-radius: 8px;
      font-weight: 500;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: white;
      color: black;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="message"><?= $message ?></div>
  </div>
</body>
</html>
