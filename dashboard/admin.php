  <?php
  session_start();
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
      header("Location: ../login.html");
      exit;
  }
  ?>

  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Query Management System</title>
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
    flex-wrap: wrap; /*allows wrapping */
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
    align-items: start;
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

  /*Responsive adjustments */
  @media (max-width: 768px) {
    .navbar {
      flex-direction: column;
      align-items: flex-start;
      gap: 10px;
    }

    .navbar .nav-links {
      width: 100%;
      flex-direction: column;
      align-items: flex-start;
    }
  }



      .dashboard-heading {
        text-align: center;
        font-size: 32px;
        font-weight: bold;
        margin: 30px 0 10px;
        text-shadow: 0 0 10px rgba(255,255,255,0.4);
      }

      .welcome {
        text-align: center;
        font-size: 18px;
        margin-bottom: 20px;
      }

      #queryList {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
        padding: 30px;
        max-width: 1200px;
        margin: auto;
      }

      .query-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        animation: fadeInUp 0.8s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }

      .query-card span.label {
        font-weight: bold;
        color: #ffeaa7;
      }

      .query-card .query-info {
        margin-bottom: 10px;
      }

      textarea, select {
        width: 100%;
        margin-top: 10px;
        padding: 10px;
        border-radius: 10px;
        border: none;
        font-size: 15px;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        resize: vertical;
        outline: none;
      }

      textarea::placeholder {
        color: rgba(255,255,255,0.6);
      }

      button {
        padding: 10px 20px;
        background: #6c5ce7;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background 0.3s ease;
        margin-top: 8px;
      }

      button:hover {
        background: #4834d4;
      }

      @media(max-width: 768px) {
        .dashboard-heading {
          font-size: 26px;
        }

        .navbar {
          flex-direction: column;
          align-items: flex-start;
        }

        .navbar .nav-links {
          margin-top: 10px;
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

    <!--Header -->
    <div class="dashboard-heading">Admin Dashboard</div>
    <div class="welcome">Welcome Admin, <?php echo $_SESSION['name']; ?>!</div>

    <!--Query List -->
    <div id="queryList">Loading queries...</div>

    <!--JS for Query Rendering -->
    <script>
      fetch('../api/get_queries.php')
        .then(response => response.json())
        .then(data => {
          const container = document.getElementById('queryList');
          container.innerHTML = '';

          if (data.length === 0) {
            container.innerHTML = "<p style='text-align:center;'>No queries found.</p>";
            return;
          }

          data.forEach(q => {
            container.innerHTML += `
              <div class="query-card">
                <div class="query-info"><span class="label">User:</span> ${q.name}</div>
                <div class="query-info"><span class="label">Subject:</span> ${q.subject}</div>
                <div class="query-info"><span class="label">Category:</span> ${q.category}</div>
                <div class="query-info"><span class="label">Status:</span> ${q.status}</div>
                <div class="query-info"><span class="label">Message:</span> ${q.message}</div>

                <form action="../api/respond_query.php" method="POST">
                  <input type="hidden" name="query_id" value="${q.id}">
                  <textarea name="response" placeholder="Reply here..." required></textarea>
                  <button type="submit">Send Response</button>
                </form>

                <form action="../api/update_status.php" method="POST">
                  <input type="hidden" name="query_id" value="${q.id}">
                  <select name="status" required>
                    <option value="New" ${q.status === 'New' ? 'selected' : ''}>New</option>
                    <option value="In Progress" ${q.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                    <option value="Resolved" ${q.status === 'Resolved' ? 'selected' : ''}>Resolved</option>
                  </select>
                  <button type="submit">Update Status</button>
                </form>
              </div>
            `;
          });
        });
    </script>
  </body>
  </html>
