<?php
session_start();
include 'db.php';
include 'header.php';


$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'admin_dashboard';

if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit();
}

$username = $_SESSION['username'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($res);
if($user['role'] != 'admin'){
    header("Location:index.php");
    exit();
}

// Admin stats
$total_users = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS count FROM users"))['count'];
$total_files = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS count FROM files"))['count'];
$online_users = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS count FROM users WHERE is_logged_in=1"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - File Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{background:#f8f9fa;color:#212529;}
.card{background:#ffffff;transition:0.3s;margin-bottom:20px;}
.card:hover{background:#e9ecef;}
a{text-decoration:none;color:#0d6efd;}
a:hover{text-decoration:underline;}
.navbar-brand{font-weight:bold;}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
  <a class="navbar-brand" href="#"><i class="bi bi-shield-lock-fill"></i> Admin Portal</a>
  <div class="ms-auto">
    <span class="me-3">Hello, <?php echo $username; ?></span>
    <a href="logout.php" class="btn btn-outline-dark btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</nav>

<div class="container mt-4">
<div class="row text-center">
<div class="col-md-4">
  <div class="card p-3 shadow">
    <h3><i class="bi bi-people-fill"></i> <?php echo $total_users; ?></h3>
    <p>Total Users</p>
  </div>
</div>
<div class="col-md-4">
  <div class="card p-3 shadow">
    <h3><i class="bi bi-folder-fill"></i> <?php echo $total_files; ?></h3>
    <p>Total Files</p>
  </div>
</div>
<div class="col-md-4">
  <div class="card p-3 shadow">
    <h3><i class="bi bi-person-check-fill"></i> <?php echo $online_users; ?></h3>
    <p>Online Users</p>
  </div>
</div>
</div>

<div class="row mt-4">
<div class="col-md-6">
  <a href="view_file.php">
    <div class="card p-4 shadow text-center">
      <i class="bi bi-folder2-open" style="font-size:2rem;"></i>
      <h5 class="mt-2">Manage Files</h5>
    </div>
  </a>
</div>
<div class="col-md-6">
  <a href="index.php">
    <div class="card p-4 shadow text-center">
      <i class="bi bi-house-door-fill" style="font-size:2rem;"></i>
      <h5 class="mt-2">User Dashboard</h5>
    </div>
  </a>
</div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
