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

$result = mysqli_query($conn,"SELECT * FROM users");
?>

<h2>User Management</h2>
<a href="add_user.php">Add New User</a>

<table border="1">

<tr>
<th>ID</th>
<th>Username</th>
<th>Role</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['user_id']; ?></td>
<td><?php echo $row['username']; ?></td>
<td><?php echo $row['role']; ?></td>

<td>
<a href="edit_user.php?id=<?php echo $row['user_id']; ?>">Edit</a>
|
<a href="delete_user.php?id=<?php echo $row['user_id']; ?>">Delete</a>

</td>

</tr>

<?php } ?>

</table>