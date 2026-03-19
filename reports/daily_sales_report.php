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

$today = date("Y-m-d");

$daily_sales = mysqli_query($conn,"
SELECT sale_id, customer_name, date, total_amount
FROM sales
WHERE date='$today'
ORDER BY sale_id DESC
");

$total_daily = 0;
?>
<head>
<style>
@media print {
    .no-print {
        display: none;
    }
}
</style>
</head>
<h2>Daily Sales Report (<?php echo $today; ?>)</h2>

<table border="1">
<tr>
<th>Sale ID</th>
<th>Customer</th>
<th>Date</th>
<th>Total Amount</th>
</tr>

<?php while($row = mysqli_fetch_assoc($daily_sales)){
    $total_daily += $row['total_amount'];
?>
<tr>
<td><?php echo $row['sale_id']; ?></td>
<td><?php echo $row['customer_name']; ?></td>
<td><?php echo $row['date']; ?></td>
<td><?php echo number_format($row['total_amount'],2); ?></td>
</tr>
<?php } ?>
<tr>
<td colspan="3" style="text-align:right"><b>Total</b></td>
<td><?php echo number_format($total_daily,2); ?></td>
</tr>
</table>
<br>
    <button class="no-print" onclick="window.print()">Save as PDF</button>
</div>