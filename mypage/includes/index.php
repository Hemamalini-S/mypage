<?php
// You can add session_start() here if you want to check login status
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to MyPage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        h1 {
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background: rgba(0,0,0,0.3);
            border: 2px solid white;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn:hover {
            background: white;
            color: #2575fc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to MyPage</h1>
        <p>Your secure registration & login system</p>
        <a href="register.php" class="btn">Register</a>
        <a href="login.php" class="btn">Login</a>
        <a href="forgot_password.php" class="btn">Forgot Password</a>
    </div>
</body>
</html>
