<?php
require 'includes/config.php';

$token = $_GET['token'] ?? '';

if (!$token) {
    die('Invalid verification link.');
}

$stmt = $pdo->prepare("SELECT id, token_expiry FROM users WHERE verification_token = :token");
$stmt->execute(['token' => $token]);
$user = $stmt->fetch();

if (!$user) {
    die('Invalid or already used token.');
}

if (strtotime($user['token_expiry']) < time()) {
    die('Verification token expired.');
}

// mark verified
$upd = $pdo->prepare("UPDATE users SET email_verified = 1, verification_token = NULL, token_expiry = NULL WHERE id = :id");
$upd->execute(['id' => $user['id']]);

echo "<div style='max-width:600px;margin:40px auto;padding:20px;background:#fff;'>Email verified! <a href='login.php'>Login now</a></div>";
