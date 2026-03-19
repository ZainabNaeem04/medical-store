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

mysqli_query($conn,"DELETE FROM users WHERE user_id=$id");

header("Location:view_users.php");
?>