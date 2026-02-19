<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Hardcoded credentials as requested
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['admin'] = true;
        header('Location: update.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Real Estate Hub</title>
  <style>
    body { background: linear-gradient(to right, #e0f7fa, #f9f9f9); font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; margin: 0; color: #333; line-height: 1.6; }
    .login-container { background: #fff; width: 360px; padding: 40px 30px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15); text-align: center; margin: 50px auto; }
    h2 { color: #2c5282; margin-bottom: 20px; }
    .form-group { margin-bottom: 20px; text-align: left; }
    label { color: #2c5282; font-weight: 600; display: block; margin-bottom: 5px; }
    input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #b6d4fe; border-radius: 6px; box-sizing: border-box; }
    .btn-primary { background: linear-gradient(to right, #2c5282, #4a90e2); color: #fff; border: none; padding: 12px 0; border-radius: 8px; font-size: 16px; cursor: pointer; width: 100%; transition: background 0.3s; }
    .btn-primary:hover { opacity: 0.9; }
    .error-msg { color: #e53e3e; margin-bottom: 15px; font-size: 14px; background: #fff5f5; padding: 10px; border-radius: 5px; border: 1px solid #fed7d7; }
    nav { margin-bottom: 30px; text-align: center; padding-top: 20px; }
    nav a { color: #2c5282; text-decoration: none; padding: 8px 16px; }
    nav a:hover { text-decoration: underline; }
  </style>
</head>
<body>
<nav>
  <a href="home.html">Home</a> |
  <a href="properties.php">Properties</a> |
  <a href="update.php">Update</a> |
  <a href="calculator.php">Calculator</a> |
  <a href="contact.php">Contact & Search</a> 

</nav>
<div class="login-container">
  <h2>Log in as ADMIN</h2>
  <?php if($error): ?>
    <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
  <?php endif; ?>
  <form method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input required type="text" id="username" name="username" autofocus>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input required type="password" id="password" name="password">
    </div>
    <button class="btn-primary" type="submit">Log in as ADMIN</button>
  </form>
</div>
</body>
</html>
