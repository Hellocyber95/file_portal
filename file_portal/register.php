<?php
session_start();
include 'db.php';
include 'header.php';

$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'register';


if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($conn,"SELECT * FROM users WHERE username='$username'");
    if(mysqli_num_rows($check) > 0){
        $error = "❌ Username already exists!";
    } else {
        mysqli_query($conn,"INSERT INTO users(username,password) VALUES('$username','$password')");
        $success = "✅ Registration successful! <a href='login.php'>Login here</a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - File Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
  background-color: #f8f9fa;
  font-family: 'Segoe UI', Arial, sans-serif;
}
.card {
  background-color: #ffffff;
  border-radius: 10px;
  padding: 30px;
  margin-top: 100px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  transition: 0.3s;
}
.card:hover {
  transform: translateY(-3px);
}
.btn-primary {
  background-color: #0d6efd;
  border: none;
  font-weight: bold;
}
.btn-primary:hover {
  background-color: #0b5ed7;
}
a {
  text-decoration:none;
  color:#0d6efd;
}
a:hover {
  text-decoration:underline;
}
h3 {
  font-weight: 600;
}
</style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">
        <h3 class="text-center mb-4">📝 Register</h3>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <form method="POST">
          <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
          <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
          <button type="submit" name="register" class="btn btn-primary w-100 mb-2">Register</button>
          <a href="login.php" class="d-block text-center mt-2">🔑 Already have an account?</a>
        </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
