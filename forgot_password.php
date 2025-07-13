<?php
include 'common/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check new passwords match
    if ($new_password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Email exists, update password
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param("ss", $new_hashed, $email);
            $update->execute();

            if ($update->affected_rows > 0) {
                $msg = "🎉 Password changed successfully! <a href='login.php' class='alert-link'>Click here to login</a>.";
            } else {
                $error = "Failed to update password. Please try again.";
            }
            $update->close();
        } else {
            $error = "❌ Email not found!";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Forgot Password - ChuttiZone</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .form-control {
      border-radius: 0.75rem;
    }
    .btn-primary {
      border-radius: 0.75rem;
      font-weight: bold;
      letter-spacing: 0.5px;
    }
    .card-title {
      font-weight: bold;
    }
    .form-label {
      font-size: 0.95rem;
    }
    .footer-text {
      font-size: 0.9rem;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="card p-4" style="max-width: 420px; width: 100%;">
    <h4 class="card-title mb-3 text-center text-primary">🔑 Forgot Password</h4>
    <p class="text-center mb-4 text-muted">Reset your password securely.</p>

    <?php if (isset($msg)): ?>
      <div class="alert alert-success"><?php echo $msg; ?></div>
    <?php elseif (isset($error)): ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" autocomplete="off">
      <div class="mb-3">
        <label for="email" class="form-label">Registered Email</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="your@email.com" required>
      </div>

      <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New password" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100 mt-2">Change Password</button>
    </form>

    <div class="text-center mt-4 footer-text">
      <a href="login.php" class="text-decoration-none text-dark">← Back to Login</a>
    </div>
  </div>
</body>
</html>
