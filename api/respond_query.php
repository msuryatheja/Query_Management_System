<?php
session_start();
require '../db/db_connect.php';

$message = "";
$type = ""; // success or error

// Only admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    $message = " Unauthorized access.";
    $type = "error";
} elseif (!isset($_POST['query_id'], $_POST['response']) || empty(trim($_POST['response']))) {
    $message = " Response cannot be empty.";
    $type = "error";
} else {
    $query_id = intval($_POST['query_id']);
    $response = trim($_POST['response']);
    $admin_id = $_SESSION['user_id'];

    // Optional: Verify query exists
    $check = $conn->prepare("SELECT id FROM queries WHERE id = ?");
    $check->bind_param("i", $query_id);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 0) {
        $message = " Query not found.";
        $type = "error";
    } else {
        // Insert response
        $stmt = $conn->prepare("INSERT INTO responses (query_id, admin_id, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $query_id, $admin_id, $response);

        if ($stmt->execute()) {
            $message = " Response submitted successfully!";
            $type = "success";
        } else {
            $message = " Something went wrong. Try again.";
            $type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Response Status</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(-45deg, #1abc9c, #16a085, #2980b9, #8e44ad);
      background-size: 400% 400%;
      animation: gradient 15s ease infinite;
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
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 8px 30px rgba(0,0,0,0.2);
      animation: fadeIn 0.8s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .message {
      font-size: 24px;
      font-weight: bold;
      color: <?php echo $type === "success" ? "#2ecc71" : "#e74c3c"; ?>;
      margin-bottom: 20px;
    }

    .back-btn {
      padding: 10px 20px;
      border: none;
      border-radius: 10px;
      background: #ffffff33;
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: #ffffff55;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="message"><?php echo $message; ?></div>
  </div>
</body>
</html>
