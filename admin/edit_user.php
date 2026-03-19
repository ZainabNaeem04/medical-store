<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user'])){
header("Location: ../login.php");
exit();
}

$query = mysqli_query($conn,"SELECT role FROM users WHERE username='".$_SESSION['user']."'");
$user = mysqli_fetch_assoc($query);

if($user['role'] != 'admin'){
echo "Access Denied!";
exit();
}
?>

<?php
include "../config.php";

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM users WHERE user_id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$username = $_POST['username'];
$role = $_POST['role'];

mysqli_query($conn,"UPDATE users SET
username='$username',
role='$role'
WHERE user_id=$id");

header("Location:view_users.php");
}
?>

<h2>Edit User</h2>

<form method="post">

Username
<input type="text" name="username" value="<?php echo $row['username']; ?>"><br>

Role
<select name="role">
<option value="admin">Admin</option>
<option value="staff">Staff</option>
</select>

<br><br>

<button type="submit" name="update">Update</button>

</form>