<?php
session_start();
include "config.php";

if(!isset($_SESSION['user'])){
header("Location: login.php");
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
$host = "localhost";
$user = "root";
$pass = "";
$db   = "medical_store";

$filename = "backup_" . date("Y-m-d") . ".sql";

header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=$filename");

// FULL PATH (IMPORTANT)
$mysqldump = "C:\\xampp\\mysql\\bin\\mysqldump.exe";

// command
$command = "$mysqldump --user=$user --password=$pass $db";

// run and output
passthru($command);
exit;
?>