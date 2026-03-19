<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user'])){
header("Location: ../login.php");
exit();
}

$result = mysqli_query($conn,"SELECT role FROM users WHERE username='".$_SESSION['user']."'");
$user = mysqli_fetch_assoc($result);

if($user['role'] != 'admin'){
echo "Access Denied!";
exit();
}
?>

<?php
include "../config.php";

if(isset($_POST['submit'])){

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

mysqli_query($conn,"INSERT INTO users(username,password,role)
VALUES('$username','$password','$role')");

echo "User Added Successfully";
}
?>

<h2>Add User</h2>

<form method="post">

Username<br>
<input type="text" name="username"><br>

Password<br>
<input type="password" name="password"><br>

Role<br>
<select name="role">
<option value="admin">Admin</option>
<option value="staff">Staff</option>
</select>

<br><br>

<button type="submit" name="submit">Add User</button>

</form>