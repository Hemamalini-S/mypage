<?php
// includes/config.php
session_start();

$base_url = 'http://localhost/myapp'; // change if needed

// Database
define('DB_HOST','127.0.0.1');
define('DB_NAME','mypage_db');
define('DB_USER','root');
define('DB_PASS',''); // default XAMPP root has empty password

// Mail (Gmail example) - replace with your credentials
define('MAIL_HOST','smtp.gmail.com');
define('MAIL_USERNAME','hsri81009@gmail.com');       // your SMTP username (email)
define('MAIL_PASSWORD','hemz@2004');    // app password or SMTP password
define('MAIL_FROM','hsri81009@gmail.com');
define('MAIL_FROM_NAME','Mypage');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}


