<?php
require 'includes/config.php';

$token = $_GET['token'] ?? ($_POST['token'] ?? '');
$errors = [];
$success = '';

if (!$token) {
    die('Invalid link.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $p1 = $_POST['password'] ?? '';
    $p2 = $_POST['password_confirm'] ?? '';
    if (!$p1 || $p1 !== $p2) { $errors[] = "Passwords do not match."; }
    else {
        // validate token
        $stmt = $pdo->prepare("SELECT id, token_expiry FROM users WHERE password_reset_token = :token");
        $stmt->execute(['token'=>$token]);
        $user = $stmt->fetch();
        if (!$user) { $errors[] = "Invalid token."; }
        elseif (strtotime($user['token_expiry']) < time()) { $errors[] = "Token expired."; }
        else {
            $pw_hash = password_hash($p1, PASSWORD_DEFAULT);
            $upd = $pdo->prepare("UPDATE users SET password = :pw, password_reset_token = NULL, token_expiry = NULL WHERE id = :id");
            $upd->execute(['pw'=>$pw_hash, 'id'=>$user['id']]);
            $success = "Password changed. You can <a href='login.php'>login now</a>.";
        }
    }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Reset Password</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
  <h2>Reset Password</h2>
  <?php if($errors): foreach($errors as $e): ?><div class="alert"><?php echo htmlspecialchars($e); ?></div><?php endforeach; endif; ?>
  <?php if($success): ?><div class="alert" style="background:#dfd;"><?php echo $success; ?></div><?php else: ?>
  <form method="post">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
    <label>New password</label>
    <input type="password" name="password" required>
    <label>Confirm new password</label>
    <input type="password" name="password_confirm" required>
    <button type="submit">Set new password</button>
  </form>
  <?php endif; ?>
</div>
</body>
</html>
