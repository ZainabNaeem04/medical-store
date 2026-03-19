<?php
session_start();
include "config.php";

if(!isset($_SESSION['user'])){
header("Location: login.php");
exit();
}

// Get user role
$username = $_SESSION['user'];
$result = mysqli_query($conn,"SELECT role FROM users WHERE username='$username'");
$user = mysqli_fetch_assoc($result);
?>

<?php
$low_stock = mysqli_query($conn,"
SELECT *, name as medicine_name FROM medicines
WHERE quantity < 10
");

$count_low = mysqli_num_rows($low_stock);
?>

<?php if($count_low > 0){ ?>
<div style="color:red; font-weight:bold;">
⚠ Low Stock Alert: <?php $res = mysqli_query($conn,"SELECT GROUP_CONCAT(name) as names FROM medicines WHERE quantity < 10"); $row = mysqli_fetch_assoc($res); echo $row['names']; ?>
</div>
<?php } ?>

<?php
$today = date("Y-m-d");
$expiry_limit = date("Y-m-d", strtotime("+30 days"));

$near_expiry = mysqli_query($conn,"
SELECT * FROM medicines
WHERE expiry_date BETWEEN '$today' AND '$expiry_limit'
");

$count_expiry = mysqli_num_rows($near_expiry);
?>

<?php if($count_expiry > 0){ ?>
<div style="color:orange; font-weight:bold;">
⚠ Expiry Alert: <?php $res = mysqli_query($conn,"SELECT GROUP_CONCAT(name) as names FROM medicines WHERE expiry_date BETWEEN '$today' AND '$expiry_limit'"); $row = mysqli_fetch_assoc($res); echo $row['names']; ?> (Expires between <?php echo $today; ?> and <?php echo $expiry_limit; ?>)
</div>
<?php } ?>



<!DOCTYPE html>
<html>
<head>

<title>Dashboard</title>

<link rel="stylesheet" href="css/style.css">

</head>

<body>

<div class="dashboard">

<h1>Medical Store Dashboard</h1>

<p>Welcome, <?php echo $username; ?> (<?php echo $user['role']; ?>)</p>

<div class="menu">

<a href="medicines/view_medicine.php">Manage Medicines</a>
<a href="suppliers/view_supplier.php">Suppliers</a>
<a href="customers/view_customer.php">Customers</a>
<a href="sales/new_sale.php">New Sale</a>
<a href= "reports/stock_report.php">Stock Report</a>
<a href= "reports/expiry_report.php">Expiry Report</a>

<?php if($user['role'] == 'admin'){ ?>
<a href="admin/view_users.php">Manage Users</a>
<a href="purchases/new_purchase.php">New Purchase</a>
<a href="reports/daily_sales_report.php">Daily Sales Report</a>
<a href="reports/monthly_sales_report.php">Monthly Sales Report</a>
<a href="backup.php">Backup Database</a>
<?php } ?>

<a href="logout.php">Logout</a>

</div>

</div>

</body>
</html>