<?php
session_start();
include 'db.php';
include 'header.php';

$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'logout';

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    mysqli_query($conn,"UPDATE users SET is_logged_in=0 WHERE username='$username'");
    session_destroy();
}
header("Location:login.php");
exit();
?>
