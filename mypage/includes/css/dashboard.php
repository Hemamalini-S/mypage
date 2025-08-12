<?php
require 'includes/config.php';
if (empty($_SESSION['user_id'])) {
    header('Location: login.php'); exit;
}
$stmt = $pdo->prepare("SELECT id, first_name, email FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Dashboard</title></head><body>
<div style="max-width:700px;margin:40px auto;background:#fff;padding:20px;">
  <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?></h2>
  <p>Your email: <?php echo htmlspecialchars($user['email']); ?></p>
  <p><a href="logout.php">Logout</a></p>
</div>
</body></html>
