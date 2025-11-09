<?php
session_start();
include 'db.php';
include 'header.php';

$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'upload';


// Prevent directory traversal attempts
$request = $_SERVER['REQUEST_URI'];
if (strpos($request, '../') !== false || strpos($request, '..\\') !== false) {
    header("Location: index.php");
    exit();
}

if(!isset($_SESSION['username'])){
    header("Location:login.php");
    exit();
}

$username = $_SESSION['username'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($res);
$user_id = $user['id'];

if(isset($_POST['upload'])){
    if(isset($_FILES['file'])){
        // Sanitize filename
        $filename = basename($_FILES['file']['name']);
        $filename = preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $filename);

        $tmp = $_FILES['file']['tmp_name'];
        $path = "uploads/".$filename;

        if(move_uploaded_file($tmp, $path)){
            mysqli_query($conn,"INSERT INTO files(user_id, filename) VALUES($user_id,'$filename')");
            $success = "✅ File uploaded successfully!";
        } else {
            $error = "❌ Upload failed!";
        }
    } else {
        $error = "❌ No file selected!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload File - File Portal</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Arial, sans-serif;
}
.card {
    background: #ffffff;
    margin-top: 50px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
}
.btn-primary {
    background-color: #0d6efd;
    border: none;
}
.alert {
    border-radius: 8px;
}
</style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow">
                <h3 class="text-center mb-3">📤 Upload File</h3>
                <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
                <form method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" class="form-control mb-3" required>
                    <button type="submit" name="upload" class="btn btn-primary w-100">Upload</button>
                    <a href="index.php" class="d-block text-center mt-2">⬅ Back to Dashboard</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
