<?php
session_start();

if(isset($_SESSION['user'])){
header("Location: dashboard.php");
exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Medical Store Management System</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="container">

<h1>Medical Store Management System</h1>

<p>Welcome to the pharmacy management system.</p>

<a href="login.php">Login to System</a>

</div>

</body>
</html>