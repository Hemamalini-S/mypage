<?php
require 'includes/config.php';
require 'includes/functions.php';

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $username   = trim($_POST['username'] ?? '');
    $email      = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $password   = $_POST['password'] ?? '';
    $dob        = $_POST['dob'] ?? null;
    $languages  = isset($_POST['languages']) ? implode(',', $_POST['languages']) : '';
    $country    = $_POST['country'] ?? '';
    $state      = $_POST['state'] ?? '';
    $city       = $_POST['city'] ?? '';

    if (!$first_name || !$username || !$email || !$password) {
        $errors[] = "Please fill required fields.";
    }

    // check duplicate email/username
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email OR username = :username");
    $stmt->execute(['email' => $email, 'username' => $username]);
    if ($stmt->fetch()) {
        $errors[] = "Email or username already in use.";
    }

    if (empty($errors)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(16));
        $token_expiry = date('Y-m-d H:i:s', strtotime('+24 hours'));

        $ins = $pdo->prepare("INSERT INTO users (first_name,last_name,username,email,password,dob,languages,country,state,city,verification_token,token_expiry)
            VALUES (:first_name,:last_name,:username,:email,:password,:dob,:languages,:country,:state,:city,:token,:expiry)");
        $ins->execute([
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'username'=>$username,
            'email'=>$email,
            'password'=>$password_hash,
            'dob'=>$dob ?: null,
            'languages'=>$languages,
            'country'=>$country,
            'state'=>$state,
            'city'=>$city,
            'token'=>$token,
            'expiry'=>$token_expiry
        ]);

        // send verification email
        $verify_link = $base_url . '/verify.php?token=' . $token;
        $subject = "Verify your email";
        $body = "<p>Hi {$first_name},</p>
                 <p>Click to verify your email:</p>
                 <p><a href='{$verify_link}'>{$verify_link}</a></p>
                 <p>If you did not sign up, ignore this email.</p>";

        if (send_email($email, $subject, $body)) {
            $success = "Registration successful! Check your email for verification link.";
        } else {
            $errors[] = "Registration saved but failed to send verification email. Check server mail settings.";
        }
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Register</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
  <h2>Register</h2>

  <?php if($errors): foreach($errors as $e): ?>
    <div class="alert" style="background:#fdd;"><?php echo htmlspecialchars($e); ?></div>
  <?php endforeach; endif; ?>

  <?php if($success): ?>
    <div class="alert" style="background:#dfd;"><?php echo htmlspecialchars($success); ?></div>
  <?php endif; ?>

  <form method="post" action="">
    <label>First name *</label>
    <input name="first_name" required>

    <label>Last name</label>
    <input name="last_name">

    <label>Username *</label>
    <input name="username" required>

    <label>Email *</label>
    <input type="email" name="email" required>

    <label>Password *</label>
    <input type="password" name="password" required>

    <label>Date of birth</label>
    <input type="date" name="dob">

    <label>Known languages (hold ctrl to multi-select)</label>
    <select name="languages[]" multiple>
      <option value="Tamil">Tamil</option>
      <option value="English">English</option>
      <option value="Hindi">Hindi</option>
    </select>

    <label>Country</label>
    <input name="country">

    <label>State</label>
    <input name="state">

    <label>City</label>
    <input name="city">

    <button type="submit">Register</button>
  </form>

  <p><a href="login.php">Already have an account? Login</a></p>
</div>
</body>
</html>
