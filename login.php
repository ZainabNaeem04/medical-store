<?php
session_start();
include "config.php";

if(isset($_POST['login'])){

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result) == 1){

$_SESSION['user'] = $username;

header("Location: dashboard.php");
exit();

}else{
$error = "Invalid username or password";
}
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login - Medical Store</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="login-container">

<h2>Medical Store Login</h2>

<?php
if(isset($error)){
echo "<p class='error'>$error</p>";
}
?>

<form method="post">

<label>Username</label>
<input type="text" name="username" required>

<label>Password</label>
<input type="password" name="password" required>

<button type="submit" name="login">Login</button>

</form>
</div>

</body>

</html>