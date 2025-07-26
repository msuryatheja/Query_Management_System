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

workflow:
step 1:
Register-for-customer
  <img width="1365" height="599" alt="Register-for-customer" src="https://github.com/user-attachments/assets/5b824475-d88e-4db9-9d08-e38a42b84f28" />
step 2:
login-cutomer
<img width="1365" height="597" alt="login-cutomer" src="https://github.com/user-attachments/assets/4654a970-4433-464c-869b-8b9eec4f800c" />
step 3:
customer-query
<img width="1354" height="591" alt="customer-query" src="https://github.com/user-attachments/assets/17cf5c42-cc7f-4aa0-99aa-04df19d98036" />
step 4:
Register-for-admin
<img width="1365" height="606" alt="Register-for-admin" src="https://github.com/user-attachments/assets/4961eac2-e8c2-434c-925a-9ae8bd97f934" />
step 5:
login-admin
<img width="1365" height="604" alt="login-admin" src="https://github.com/user-attachments/assets/98682d33-f280-4b47-81b1-6285101ed2a6" />
step 6:
responce-from-admin
<img width="1365" height="603" alt="responce-from-admin" src="https://github.com/user-attachments/assets/3effd37a-3f42-447d-a076-2e4cc5d86f1b" />
step 7:
responce-received-to-customer
<img width="1365" height="600" alt="responce-received-to-customer" src="https://github.com/user-attachments/assets/2620fcfe-441e-45b3-8255-a78fd3986c75" />







