<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = ""; // Your MySQL password
$dbname = "file_portal";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>