<?php
session_start();
include 'db.php';
include 'header.php';

$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'view_file';

if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit();
}

$username = $_SESSION['username'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($res);
$user_id = $user['id'];
$role = $user['role'];

if(isset($_GET['delete']) && $role=='admin'){
    $file_id = $_GET['delete'];
    $file = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM files WHERE id=$file_id"));
    if($file){
        unlink("uploads/".$file['filename']);
        mysqli_query($conn,"DELETE FROM files WHERE id=$file_id");
        $success = "File deleted!";
    }
}

$files = mysqli_query($conn,"SELECT f.*, u.username FROM files f JOIN users u ON f.user_id=u.id ORDER BY f.id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View Files - File Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body{background:#f8f9fa;color:#212529;}
.card{background:#ffffff;margin-top:20px;}
a{text-decoration:none;color:#0d6efd;}
a:hover{text-decoration:underline;}
</style>
</head>
<body>
<div class="container mt-4">
<h3 class="mb-3">Files</h3>
<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
<table class="table table-striped table-hover bg-white shadow">
<thead>
<tr>
<th>ID</th>
<th>Filename</th>
<th>Uploaded By</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($file = mysqli_fetch_assoc($files)): ?>
<tr>
<td><?php echo $file['id']; ?></td>
<td><a href="uploads/<?php echo $file['filename']; ?>" target="_blank"><?php echo $file['filename']; ?></a></td>
<td><?php echo $file['username']; ?></td>
<td>
<?php if($role=='admin'): ?>
<a href="?delete=<?php echo $file['id']; ?>" class="btn btn-sm btn-danger">Delete</a>
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<a href="index.php" class="d-block mt-3">Back to Dashboard</a>
</div>
</body>
</html>
