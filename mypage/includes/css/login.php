<?php
require 'includes/config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$identifier || !$password) {
        $errors[] = "Please enter username/email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :id OR username = :id LIMIT 1");
        $stmt->execute(['id' => $identifier]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password'])) {
            if (!$user['email_verified']) {
                $errors[] = "Please verify your email before logging in.";
            } else {
                // login success
                $_SESSION['user_id'] = $user['id'];
                header('Location: dashboard.php');
                exit;
            }
        } else {
            $errors[] = "Incorrect credentials.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <h2>Login</h2>
  <?php if($errors): foreach($errors as $e): ?><div class="alert"><?php echo htmlspecialchars($e); ?></div><?php endforeach; endif; ?>

  <form method="post">
    <label>Email or Username</label>
    <input name="identifier" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
  </form>
  <p><a href="forgot_password.php">Forgot password?</a></p>
  <p><a href="register.php">Register</a></p>
</div>
</body>
</html>
