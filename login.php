
<?php
session_start();
include 'common/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($pass, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Role-based redirection
            if ($user['role'] == 'student') {
                header("Location: student/dashboard.php");
            } elseif ($user['role'] == 'admin') {
                header("Location: admin/dashboard.php");
            } else {
                header("Location: index.php"); // Fallback or unknown role
            }
            exit();
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "❌ User not found.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login – EZLeave</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0f7fa, #ffffff);
      font-family: 'Segoe UI', sans-serif;
    }

    .login-container {
      max-width: 450px;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      margin-top: 50px;
    }

    .logo {
      width: 100px;
      margin-bottom: 20px;
    }

    .form-label {
      font-weight: 500;
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="login-container text-center">

    <!-- Logo -->
    <img src="assets/images/logo.png" alt="EZLeave Logo" class="logo">

    <h3 class="mb-4">🔐 Login to EZLeave</h3>

    <?php if (isset($error)) : ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="text-start">
      <div class="mb-3">
        <label class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>

    <div class="mt-4 text-center">
      <p class="mb-1">No account? <a href="register.php">Register here</a></p>
      <p><a href="forgot_password.php">Forgot Password?</a></p>
    </div>

  </div>
</div>

</body>
</html>
