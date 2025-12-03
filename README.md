🌟 Employee Management System (PHP + MySQL)

A complete LAMP stack Employee Management Web Application built using PHP, MySQL, Apache, HTML, CSS, JavaScript.
Created for learning full-stack fundamentals, portfolio showcasing, and real-world job readiness.

🚀 Features
🔐 Authentication

Login page

Signup page (optional)

Session-based authentication

Protected routes

👨‍💼 Employee Management (CRUD)

Add Employee

Edit Employee

Delete Employee (POST + CSRF protected)

Search Employees by name, email, position

Pagination

Form validation

🎨 UI/UX

Modern animated landing page

Poppins font

Responsive layout

Clean dashboard design

Polished table layout

Styled forms and buttons

Flash success/error messages

🛠 Backend Logic

Pure PHP (No frameworks)

mysqli prepared statements

Secure delete flow (POST only)

XSS protection via escaping

Centralized config + URL helper

📂 Project Structure
employee_mgmt/
│
├── landing.php
├── index.php
├── create.php
├── edit.php
├── delete.php
├── db.php
├── config.php
│
├── auth/
│   ├── login.php
│   └── signup.php
│
├── partials/
│   ├── header.php
│   └── footer.php
│
├── public/
│   ├── style.css
│   ├── app.js
│   └── img/
│
├── .htaccess
└── README.md

🗄️ Database Structure

Database: employee_db
Table: employees

CREATE TABLE `employees` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL UNIQUE,
  `position` VARCHAR(80) NOT NULL,
  `salary` DECIMAL(10,2) NOT NULL,
  `joined_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

🔧 Tech Stack
Layer	Technology
Frontend	HTML5, CSS3, JavaScript, Poppins Font
Backend	PHP 8+, mysqli
Database	MySQL
Server	Apache (XAMPP / LAMP)
Security	CSRF Token, Prepared Statements, Sessions
⚙️ How to Run Locally
1️⃣ Install XAMPP

Download: https://www.apachefriends.org/

Start:

Apache

MySQL

2️⃣ Move project to htdocs

Place folder in:

C:\xampp\htdocs\employee_mgmt

3️⃣ Create database

Open phpMyAdmin:

http://localhost/phpmyadmin/


Create:

employee_db


Import your SQL file.

4️⃣ Update db.php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASS = "";
$DB_NAME = "employee_db";

5️⃣ Run app
http://localhost/employee_mgmt/

🧪 Manual Test Cases
✔ Add Employee

Go to Add Employee → fill form → Save → appears in list.

✔ Edit Employee

Click Edit → update fields → Save → list refreshed.

✔ Delete Employee

Click Delete → confirm popup → record removed.

✔ Search

Enter keyword → search results filtered.

✔ Pagination

More than 10 records shows page links.

🛡 Security Features

Prepared SQL statements everywhere

Proper output escaping

Session-based access protection

CSRF token validation for DELETE

POST-only deletion

Unique email validation

📸 Screenshots (Add your own)
📷 Landing Page  
📷 Dashboard  
📷 Add Employee  
📷 Edit Employee  
📷 Delete Confirmation  