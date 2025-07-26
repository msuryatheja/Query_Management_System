<?php
session_start();
require '../db/db_connect.php';

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $message_text = $_POST['message'];
    $order_id = $_POST['order_id'] ?? '';
    $category = $_POST['category'] ?? '';
    $file_path = '';

    // 📎 File Upload Handling
    if (!empty($_FILES['file']['name'])) {
        $target_dir = "../uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_path = $target_dir . basename($_FILES["file"]["name"]);

        if (!move_uploaded_file($_FILES["file"]["tmp_name"], $file_path)) {
            $message = "File upload failed.";
            $type = "error";
        }
    }

    //Database Insert
    if ($type !== "error") {
        $stmt = $conn->prepare("INSERT INTO queries (user_id, subject, message, order_id, category, file_path) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $subject, $message_text, $order_id, $category, $file_path);

        if ($stmt->execute()) {
            $message = "Query submitted successfully!";
            $type = "success";
        } else {
            $message = "Something went wrong. Try again.";
            $type = "error";
        }
    }
} else {
    $message = "Unauthorized or invalid request.";
    $type = "error";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Query Submission Status</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(45deg, #1d2b64, #f8cdda, #89f7fe, #66a6ff);
      background-size: 400% 400%;
      animation: moveGradient 12s ease infinite;
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    @keyframes moveGradient {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }

    .card {
      background: rgba(255, 255, 255, 0.08);
      backdrop-filter: blur(12px);
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
      animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
      from {opacity: 0; transform: translateY(20px);}
      to {opacity: 1; transform: translateY(0);}
    }

    .status-msg {
      font-size: 22px;
      font-weight: bold;
      color: <?= $type === "success" ? "#2ecc71" : "#e74c3c" ?>;
      margin-bottom: 20px;
    }

    .back-btn {
      display: inline-block;
      padding: 10px 20px;
      border-radius: 10px;
      background: #ffffff22;
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .back-btn:hover {
      background: #ffffff44;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="status-msg"><?= $message ?></div>
    <a class="back-btn" href="../customer.php">⬅ Back to Dashboard</a>
  </div>
</body>
</html>
