<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    header("Location: ../login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Customer Dashboard - Query System</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(-45deg, #1f1c2c, #928dab, #2c3e50, #3498db);
      background-size: 400% 400%;
      animation: gradientMove 15s ease infinite;
      color: white;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .navbar {
      width: 98%;
      background: rgba(0, 0, 0, 0.2);
      backdrop-filter: blur(12px);
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      box-shadow: 0 2px 10px rgba(0,0,0,0.2);
      position: sticky;
      top: 0;
      z-index: 999;
    }

    .navbar .brand {
      font-size: 22px;
      color: #fff;
      font-weight: bold;
      white-space: nowrap;
    }

    .navbar .nav-links {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      gap: 15px;
      align-items: center;
    }

    .navbar .nav-links a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      white-space: nowrap;
      transition: 0.3s;
    }

    .navbar .nav-links a:hover {
      color: #a29bfe;
    }

    .welcome {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      margin: 20px;
    }

    form {
      max-width: 600px;
      margin: auto;
      background: rgba(255,255,255,0.1);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      backdrop-filter: blur(10px);
    }

    form input, form textarea, form select {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: none;
      border-radius: 10px;
      background: rgba(255, 255, 255, 0.15);
      color: white;
      font-size: 15px;
      outline: none;
    }

    form input::placeholder, textarea::placeholder {
      color: rgba(255,255,255,0.7);
    }

    form button {
      background: #6c5ce7;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s;
    }

    form button:hover {
      background: #4834d4;
    }

    #queryList {
      max-width: 1000px;
      margin: 30px auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
      padding: 0 20px;
    }

    .query-card {
      background: rgba(255,255,255,0.08);
      backdrop-filter: blur(10px);
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
      animation: fadeInUp 0.5s ease;
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .query-card .label {
      font-weight: bold;
      color: #ffeaa7;
    }

    .replies {
      margin-top: 10px;
      font-size: 14px;
      color: #a8ffb0;
      background-color: rgba(0,0,0,0.2);
      padding: 10px;
      border-radius: 10px;
    }

    @media (max-width: 768px) {
      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .navbar .nav-links {
        width: 100%;
        flex-direction: column;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>

  <!--Navbar -->
  <div class="navbar">
    <div class="brand">Query Management System</div>
    <div class="nav-links">
      <a href="../index.html">Home</a>
      <a href="../logout.php">Logout</a>
    </div>
  </div>

  <!--Welcome -->
  <div class="welcome">Welcome, <?php echo $_SESSION['name']; ?>!</div>

  <!--Query Submission Form -->
  <form action="../api/submit_query.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="message" placeholder="Your message" required></textarea>
    <input type="text" name="order_id" placeholder="Order ID (optional)">
    <input type="text" name="category" placeholder="Category" required>
    <input type="file" name="file">
    <button type="submit">Submit Query</button>
  </form>

  <!--Query List -->
  <div id="queryList">Loading your queries...</div>

  <!--Fetch Queries -->
  <script>
    fetch('../api/get_queries.php')
      .then(response => response.json())
      .then(data => {
        const container = document.getElementById('queryList');
        container.innerHTML = '';

        if (data.length === 0) {
          container.innerHTML = "<p style='text-align:center;'>No queries submitted yet.</p>";
          return;
        }

        data.forEach(q => {
          let repliesHTML = '';
          if (q.replies && q.replies.length > 0) {
            repliesHTML = '<div class="replies"><b>Admin Replies:</b><br>';
            q.replies.forEach(r => {
              repliesHTML += ` ${r.message} <i>(${r.created_at})</i><br>`;
            });
            repliesHTML += '</div>';
          }

          container.innerHTML += `
            <div class="query-card">
              <div><span class="label">Subject:</span> ${q.subject}</div>
              <div><span class="label">Status:</span> ${q.status}</div>
              <div><span class="label">Message:</span><br>${q.message}</div>
              <div><span class="label">Date:</span> ${q.created_at}</div>
              ${repliesHTML}
            </div>
          `;
        });
      });
  </script>
</body>
</html>
