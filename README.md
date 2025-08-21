# mypage


---

# PHP Authentication System (XAMPP + PDO + PHPMailer)

A complete **user authentication system** built with PHP, MySQL (MariaDB), and PHPMailer.  
Features include:

- User Registration with email verification
- Login & Logout
- Password reset via email (forgot password)
- Basic UI with HTML/CSS
- PDO prepared statements for security
- Email sending via SMTP

---

## 📂 Project Structure

mypage/ ├── includes/ │   ├── config.php        # Database & SMTP configuration │   ├── functions.php     # Helper functions (e.g., send_email) ├── css/ │   └── style.css         # Basic styling ├── vendor/               # Composer dependencies (PHPMailer) ├── register.php          # User registration page ├── verify.php            # Email verification handler ├── login.php             # User login page ├── dashboard.php         # Protected page (after login) ├── logout.php            # Logout handler ├── forgot_password.php   # Password reset request ├── reset_password.php    # Password reset form └── README.md

---

## 🛠 Requirements

- [XAMPP](https://www.apachefriends.org/) (Apache + MySQL)
- PHP 7.4+ (recommended: PHP 8+)
- Composer (for PHPMailer)
- An SMTP account (e.g., Gmail, Mailtrap, SendGrid)

---

## ⚙️ Setup Instructions

1. **Clone or download this repository** into your XAMPP `htdocs` folder:

   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/yourusername/myapp.git

2. Install PHPMailer via Composer:

cd mypage
composer require phpmailer/phpmailer


3. Create the database and table in phpMyAdmin (http://localhost/phpmyadmin):

CREATE DATABASE myapp_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE mypage_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR(100),
  last_name VARCHAR(100),
  username VARCHAR(100) UNIQUE,
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  dob DATE,
  languages TEXT,
  country VARCHAR(100),
  state VARCHAR(100),
  city VARCHAR(100),
  email_verified TINYINT(1) DEFAULT 0,
  verification_token VARCHAR(255) DEFAULT NULL,
  password_reset_token VARCHAR(255) DEFAULT NULL,
  token_expiry DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;


4. Edit configuration:
Open includes/config.php and update:

define('DB_HOST','127.0.0.1');
define('DB_NAME','mypage_db');
define('DB_USER','root');
define('DB_PASS','');

define('MAIL_HOST','smtp.gmail.com');
define('MAIL_USERNAME','hsri81009@gmail.com');
define('MAIL_PASSWORD','hemz@2004'); // or SMTP password
define('MAIL_FROM', 'hsri81008@gmail.com');
define('MAIL_FROM_NAME', 'Mypage');

> Note: If using Gmail, enable 2FA and create an App Password.
For testing, you can use Mailtrap.




5. Start XAMPP services:

Open XAMPP Control Panel.

Start Apache and MySQL.



6. Access the app:

Open: http://localhost/mypage/register.php





---

🚀 Features

Registration → Saves user data, sends email with verification link.

Email Verification → User must click link before login is allowed.

Login → Email or username with password.

Forgot Password → Sends secure token via email to reset password.

Secure Password Storage → Uses password_hash() and password_verify().

Prepared Statements → Protects against SQL Injection.



---

🔒 Security Notes

Always use HTTPS in production.

Configure proper SMTP credentials.

Implement CSRF protection for production.

Apply rate limiting on login/reset endpoints.


---

📜 License

This project is released under the MIT License.


---

🤝 Contributing

1. Fork the repo.


2. Create your feature branch:

git checkout -b feature/YourFeature


3. Commit your changes:

git commit -m 'Add YourFeature'


4. Push to the branch:

git push origin feature/YourFeature


5. Open a Pull Request.




---

---
