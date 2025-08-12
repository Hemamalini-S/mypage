<?php
require 'includes/config.php';
require 'includes/functions.php';

$success = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if (!$email) { $errors[] = "Enter a valid email."; }
    else {
        $stmt = $pdo->prepare("SELECT id, first_name FROM users WHERE email = :email AND email_verified = 1");
        $stmt->execute(['email'=>$email]);
        $user = $stmt->fetch();
        if (!$user) {
            $errors[] = "No verified account found with that email.";
        } else {
            $token = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));
            $upd = $pdo->prepare("UPDATE users SET password_reset_token = :token, token_expiry = :expiry WHERE id = :id");
            $upd->execute(['token'=>$token, 'expiry'=>$expiry, 'id'=>$user['id']]);

            $reset_link = $base_url . '/reset_password.php?token=' . $token;
            $sub = "Password reset link";
            $body = "<p>Hi {$user['first_name']},</p>
                     <p>Click to reset your password:<br><a href='{$reset_link}'>{$reset_link}</a></p>
                     <p>This link expires in 1 hour.</p>";
            if (send_email($email, $sub, $body)) {
                $success = "Password reset email sent. Check your inbox.";
            } else {
                $errors[] = "Failed to send email. Check mail settings.";
            }
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Forgot Password</title><link rel="stylesheet" href="css/style.css"></head><body>
<div class="container">
  <h2>Forgot Password</h2>
  <?php if($errors): foreach($errors as $e): ?><div class="alert"><?php echo htmlspecialchars($e); ?></div><?php endforeach; endif; ?>
  <?php if($success): ?><div class="alert" style="background:#dfd;"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>

  <form method="post">
    <label>Email</label>
    <input type="email" name="email" required>
    <button type="submit">Send Reset Link</button>
  </form>
  <p><a href="login.php">Back to login</a></p>
</div>
</body></html>
