<?php
session_start();
require '../db/db_connect.php';

$message = "";
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role     = $_POST['role']; // either 'admin' or 'customer'

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if ($stmt->execute()) {
        $message = "Registration successful!";
        $success = true;
    } else {
        $message = "Error: Email already exists or another issue occurred.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Status - Query System</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #1f1c2c, #928dab, #3498db);
      background-size: 400% 400%;
      animation: gradientMove 15s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .status-box {
      background: rgba(0,0,0,0.3);
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      backdrop-filter: blur(10px);
      box-shadow: 0 0 20px rgba(0,0,0,0.5);
      animation: fadeIn 1s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .status-box h1 {
      font-size: 28px;
      margin-bottom: 20px;
      color: <?= $success ? '#00ffb3' : '#ff7675' ?>;
    }

    .status-box p {
      font-size: 18px;
      margin-bottom: 30px;
    }

    .status-box a {
      padding: 10px 20px;
      background: #6c5ce7;
      color: #fff;
      text-decoration: none;
      border-radius: 10px;
      font-weight: bold;
      transition: 0.3s ease;
    }

    .status-box a:hover {
      background: #4834d4;
    }
  </style>
</head>
<body>

  <div class="status-box">
    <h1><?= $success ? "Success" : "Error" ?></h1>
    <p><?= $message ?></p>
    <a href="<?= $success ? '../login.html' : '../register.html' ?>">
      <?= $success ? "Go to Login" : "Try Again" ?>
    </a>
  </div>

</body>
</html>
