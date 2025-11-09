<?php
session_start();
include 'db.php';
include 'header.php';

$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'index';

if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit();
}

$username = $_SESSION['username'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($res);
$user_id = $user['id'];
$role = $user['role'];

// Stats
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$total_files = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM files"))['count'];
$online_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users WHERE is_logged_in=1"))['count'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>📊 Dashboard - File Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
body {
    background: #f0f2f5;
    font-family: 'Segoe UI', Arial, sans-serif;
}

/* Navbar */
.navbar {
    background: linear-gradient(90deg, #ff7e5f, #feb47b);
    color: white;
    padding: 15px 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}
.navbar-brand {
    font-weight: bold;
    color: white !important;
    font-size: 1.5rem;
}
.navbar .btn-outline-dark {
    background: white;
    color: #ff7e5f;
    font-weight: bold;
    border-radius: 8px;
    transition: 0.3s;
}
.navbar .btn-outline-dark:hover {
    background: #ff7e5f;
    color: white;
}

/* Cards */
.card {
    border-radius: 12px;
    transition: 0.3s;
    cursor: pointer;
    text-align: center;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* Stat cards */
.stat-card {
    background: linear-gradient(90deg, #ff7e5f, #feb47b);
    color: white;
    padding: 30px;
}
.stat-card h3 {
    font-size: 2rem;
}
.stat-card p {
    font-weight: bold;
    font-size: 1rem;
}

/* Action cards */
.action-card {
    background: white;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    transition: 0.3s;
}
.action-card i {
    font-size: 3rem;
    color: #ff7e5f;
}
.action-card h5 {
    margin-top: 15px;
    font-weight: bold;
}
.action-card:hover {
    background: #ffe5d6;
    transform: translateY(-5px);
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg mb-4">
  <a class="navbar-brand" href="#"><i class="bi bi-file-earmark-fill"></i> File Portal</a>
  <div class="ms-auto d-flex align-items-center">
    <span class="me-3">Hello, <?php echo $username; ?> 👋</span>
    <a href="logout.php" class="btn btn-outline-dark btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</nav>

<div class="container">

  <!-- Stats -->
  <div class="row text-center mb-4">
    <div class="col-md-4">
      <div class="card stat-card shadow">
        <h3><i class="bi bi-people-fill"></i> <?php echo $total_users; ?></h3>
        <p>Total Users</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card shadow">
        <h3><i class="bi bi-folder-fill"></i> <?php echo $total_files; ?></h3>
        <p>Total Files</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card stat-card shadow">
        <h3><i class="bi bi-person-check-fill"></i> <?php echo $online_users; ?></h3>
        <p>Online Users</p>
      </div>
    </div>
  </div>

  <!-- Action Cards -->
  <div class="row g-4">
    <div class="col-md-4">
      <a href="upload.php" style="text-decoration:none;">
        <div class="card action-card shadow">
          <i class="bi bi-cloud-upload-fill"></i>
          <h5>☁️ Upload Files</h5>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a href="products.php" style="text-decoration:none;">
        <div class="card action-card shadow">
          <i class="bi bi-cart-fill"></i>
          <h5>🛍 Shop Products</h5>
        </div>
      </a>
    </div>
    <div class="col-md-4">
      <a href="view_file.php" style="text-decoration:none;">
        <div class="card action-card shadow">
          <i class="bi bi-folder2-open"></i>
          <h5>📂 View & Edit Files</h5>
        </div>
      </a>
    </div>
    <?php if($role=='admin'): ?>
    <div class="col-md-4">
      <a href="admin_dashboard.php" style="text-decoration:none;">
        <div class="card action-card shadow">
          <i class="bi bi-shield-lock-fill"></i>
          <h5>🛡 Admin Dashboard</h5>
        </div>
      </a>
    </div>
    <?php endif; ?>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
