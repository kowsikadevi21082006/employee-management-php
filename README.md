# Employee Management (Vanilla PHP + MySQL)

Minimal employee management app built with plain PHP and MySQL using `mysqli` prepared statements. Intended as a simple, secure starting point for local development (XAMPP).

Prerequisites
- XAMPP (Apache + MySQL)
- PHP 8.x recommended (works with PHP 7.4+, but PHP 8+ is preferred)

Setup

1. Copy the `employee_mgmt` folder into your XAMPP `htdocs` directory (typically `C:\xampp\htdocs`).
2. Start Apache and MySQL using the XAMPP control panel.
3. Create the database and table. Run the SQL in `schema.sql` (or via phpMyAdmin / mysql client):

```sql
CREATE DATABASE IF NOT EXISTS `employee_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `employee_db`;

CREATE TABLE IF NOT EXISTS `employees` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(120) NOT NULL UNIQUE,
  `position` VARCHAR(80) NOT NULL,
  `salary` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `joined_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);
```

4. The default DB connection in `db.php` uses `mysqli('localhost','root','', 'employee_db')`. If your MySQL password/user differs, update `db.php`.
5. Open the app in your browser: `http://localhost/employee_mgmt/`.

Features
- CRUD for employees (Create, Read, Update, Delete)
- Server-side validation (required fields, valid email, salary numeric >= 0)
- Search by name, email, or position (`q` GET parameter)
- Pagination (10 results per page)
- All DB access uses `mysqli` prepared statements
- Output escaped with `htmlspecialchars` to mitigate XSS
- CSRF protection for delete operations using a session token

Notes & Security
- This project is intended for local development/demo. For production hardening:
  - Serve over HTTPS
  - Harden session cookies (`session.cookie_secure`, `session.cookie_httponly`, `session.cookie_samesite`)
  - Use proper error logging (do not echo DB errors to users)
  - Apply stricter input validation and rate-limiting where appropriate

Screenshots (placeholders)
- screenshots/list.png
- screenshots/create.png
- screenshots/edit.png

If you want, I can add a `schema.sql` file to the project root containing the CREATE statements and sample data.
"# employee-management-php" 
