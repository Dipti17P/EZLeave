<?php
include 'common/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dept = $_POST['dept'];
    $year = $_POST['year'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, dept, year) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $name, $email, $pass, $role, $dept, $year);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "❌ Email might already be registered.";
    }
}
?>

<!DOCTYPE html> 
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register – EZLeave</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0f7fa, #ffffff);
      font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
      max-width: 500px;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
      margin-top: 60px;
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="form-container">
    <h3 class="text-center mb-4">📝 Student Registration</h3>

    <?php if (isset($error)) : ?>
      <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Create password" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Department</label>
        <input type="text" name="dept" class="form-control" placeholder="Enter department" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Year</label>
        <input type="number" name="year" class="form-control" placeholder="1, 2, 3, or 4" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
          <option value="student">👨‍🎓 Student</option>
          <option value="admin">👨‍🏫 LG / CC</option>
        </select>
      </div>

      <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <div class="text-center mt-3">
      <p class="mb-0">Already registered? <a href="login.php" class="text-decoration-none">Login here</a></p>
    </div>
  </div>
</div>

</body>
</html>
