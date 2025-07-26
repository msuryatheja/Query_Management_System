Query Management System (PHP + MySQL)

A role-based full-stack web application for managing user queries, built with PHP, MySQL, HTML, CSS, and JavaScript.

Features

Role-based Access
<img width="1365" height="767" alt="image" src="https://github.com/user-attachments/assets/c205b9b4-0515-426d-ab68-26974722138c" />

- Admin
  <img width="1365" height="767" alt="image" src="https://github.com/user-attachments/assets/149646a9-00b0-485b-9232-aef75e075d5b" />

  - View all user-submitted queries
  - Respond to queries
  - Update status (New, In Progress, Resolved)
- Customer
- <img width="1365" height="767" alt="image" src="https://github.com/user-attachments/assets/0f80b8cb-1a23-4c4b-a3d1-72e176b5704c" />

  - Register/Login securely
  - Submit new queries with optional file upload
  - View their query history and admin responses

Query Management
<img width="1365" height="767" alt="image" src="https://github.com/user-attachments/assets/933a80b7-cbd4-4212-8b8f-c4ab67eb3870" />

- Query submission includes:
  <img width="1365" height="767" alt="image" src="https://github.com/user-attachments/assets/54b858b5-bf4e-481a-b2de-29d7aca9c33b" />

  - Subject
  - Message
  - Category
  - Optional Order ID
  - Optional file attachment
- Queries can be viewed and updated in a card-based UI

UI/UX
- Responsive dashboard for both Admin and Customer
- Animated gradient backgrounds
- Centered content cards with glassmorphism effects
- Live updates from backend via `fetch()` API

---
Technologies Used

| Frontend      | Backend     | Database | Misc        |
|---------------|-------------|----------|-------------|
| HTML5, CSS3   | PHP (8.x)   | MySQL    | JavaScript  |
| Vanilla JS    | PHP Sessions |          | JSON APIs   |

---

Folder Structure

query-system/
│
├── api/ # PHP backend endpoints
│ ├── login.php
│ ├── logout.php
│ ├── register.php
│ ├── submit_query.php
│ ├── get_queries.php
│ ├── respond_query.php
│ └── update_status.php
│
├── admin/ # Admin Dashboard
│ └── dashboard.php
│
├── customer/ # Customer Dashboard
│ └── dashboard.php
│
├── assets/ # Styles
│ └── style.css
│
├── db/ # DB Connection
│ └── db_connect.php
│
├── uploads/ # Uploaded files (if any)
│
├── login.html
├── register.html
└── index.html

