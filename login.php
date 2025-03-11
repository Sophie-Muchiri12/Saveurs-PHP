<?php
session_start();
include 'db.php'; // Database connection

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['email'] = $email;
            header("Location: dashboard.php"); // Redirect to dashboard
            exit();
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "User not found";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="displayuser.css">

  <style>
    .container {
      width: 450px;
      margin: 50px auto;
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      text-align: center;
    }

    .login-form {
      width: 100%;
      max-width: 400px;
      margin: 0 auto;
      text-align: left;
    }

    .input-group {
      margin-bottom: 15px;
      display: flex;
      flex-direction: column;
    }

    .input-group label {
      font-weight: bold;
      margin-bottom: 5px;
      color: #333;
    }

    .input-group input {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .submit-button {
      width: 100%;
      padding: 10px;
      background-color: #bb9356;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .submit-button:hover {
      background-color: #a57948;
    }

    .error {
      color: red;
      margin-bottom: 10px;
      text-align: center;
    }

    p {
      text-align: center;
      margin-top: 10px;
    }

    p a {
      color: #bb9356;
      text-decoration: none;
      font-weight: bold;
    }

    p a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body style="background: url('/images/bg.svg') no-repeat center center fixed; background-size: cover;">

<div class="container">
    <h2>Saveurs du Monde</h2>
    <h2>Login</h2>

    <?php if (!empty($error)) : ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form id="login-form" class="login-form" method="POST">
      <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="submit-button">Login</button>
    </form>

    <p>Don't have an account? <a href="signup.html">Sign up here</a></p>
    
    <button onclick="logout()" class="submit-button" style="background-color: red;">Logout</button>
</div>

<script>
function logout() {
    fetch('logout.php').then(() => {
        window.location.href = 'login.php';
    });
}
</script>

</body>
</html>
